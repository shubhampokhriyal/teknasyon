<?php

namespace App\Services;

use App\Models\Device;
use App\Models\Subscription;
use \Carbon\Carbon;
use App\Events\Canceled;
use App\Events\Renewed;
use App\Events\Started;
use Log;

class SubscriptionService
{
    // Purchase request
    /***
     * Request Format:
     * {
     *      "receipt":"jsjsjsjsjsjs1",
     *      "client-token":'$2y$10$rDAVU0s2lC2TSWOCpQKIr.OUHU5ss5cpwwzxD6Yz3.opqDBL1txsm'
     * }
     * Headers: username, password
     */
    public function addSubscription($request)
    {
        $headers=$this->getHeader($request->header());
        $username=$headers['username'];
        $password=$headers['password'];
        $verify=$this->verifyReceipt($request->receipt,$username,$password);
        if(!$verify){
            return response()->json(['response'=>"Unauthorized",'status'=> 401]);
        }
        $client_token=$request->{'client-token'};
        
        $device_detail=Device::where('client_token',$client_token)
                        ->first();
        if(!$device_detail){
            return response()->json(['response'=>"Token Mismatch",'status'=> 401]);
        }
        $existingSub=Subscription::where('device_id',$device_detail->id)->where('status','<>','canceled')->first();
        $type="create";
        $event="start";
        if(!is_null($existingSub)){
            $type="update";
            $event='renew';
        }
        if($device_detail->os=='apple'){
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $verify['expiry_date'], 'UTC');
            $date->addHours(6);
            $expiry_date=$date->format('Y-m-d H:i:s');
        }
        else{
            $expiry_date=$verify['expiry_date'];
        }
        if($type=='create'){
            Subscription::create([
                'device_id'=>$device_detail->id,
                'receipt_hash'=>$request->receipt,
                'status'=>'started',
                'expiry_date'=>$expiry_date
            ]);
            event(new Started([$device_detail->appID,$device_detail->uID])); //trigger event for started sub
            return response()->json(['response'=>"Subscription started",'status'=> 200,'expiry_date'=>$expiry_date]);
        }
        else{
            Subscription::where('device_id',$device_detail->id)->update([
                'receipt_hash'=>$request->receipt,
                'status'=>'started',
                'expiry_date'=>$expiry_date
            ]);
            event(new Renewed($device_detail)); //trigger event for renewed sub
            return response()->json(['response'=>"Subscription renewed",'status'=> 200,'expiry_date'=>$expiry_date]);
        }
    }
    // Checking subscription status
    /***
     * Request Format:
     * {
     *      "client-token":'$2y$10$rDAVU0s2lC2TSWOCpQKIr.OUHU5ss5cpwwzxD6Yz3.opqDBL1txsm'
     * }
     */
    public function checkSubscription($request){
        $client_token=$request->{'client-token'};
        $device_detail=Device::where('client_token',$client_token)
                        ->first();
        if(!$device_detail){
            return response()->json(['response'=>"Token Mismatch",'status'=> 401]);
        }
        $sub = Subscription::where('device_id',$device_detail->id)->first();
        if(is_null($sub)){
            return response()->json(['response'=>"Not subscribed",'status'=> 200]);
        }
        else{
            if($sub->status=='canceled'){
                event(new Canceled([$device_detail->appID,$device_detail->uID])); //trigger event for cancelled
            }
            return response()->json(['response'=>$sub->status,'status'=> 200]);
        }
        
    }
    // For cron job
    public function updateSubscriptionStatus(){      
        Subscription::where('expiry_date','<',date('Y-m-d H:i:s'))->update(['status'=>'expired']);
        return response()->json(['response'=>"Cronjob success",'status'=> 200]);
    }
    // For getiing headers from request
    private function getHeader($headersRaw)
    {
        $headersC = collect($headersRaw)->transform(function ($item) {
            return $item[0];
        });
        $headers=$headersC->toArray();
        return $headers;
    }

    // Google API mock
    private function verifyReceipt(string $receipt, $username, $password){
        $lastChar=substr($receipt, -1);
        $number = (int) $lastChar;
        if($number%2 != 0){
            // Log::info(['receipt'=>$receipt,'username'=>$username]);
            return ['expiry_date'=>date('Y-m-d H:i:s',strtotime('+1 months'))];
        }
        return false;
    }


}