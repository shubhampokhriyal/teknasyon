<?php

namespace App\Services;

use App\Models\Device;

class DeviceService
{

    public function addDevice($request)
    {
        $token=bcrypt($request->uID.$request->appID.$request->os.date('dMYHis'));
        Device::updateOrCreate(
            ['uID' => $request->uID, 'appID' => $request->appID],
            ['language' => $request->language,
            'os' => $request->os,
            'client_token' => $token]
        );        
        return response()->json(['response'=>"register OK",'status'=> 200,'client-token'=>$token,'deviceDetails'=>$request->all()]);
    }


}
