<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Log;
use App\Events\Started;
use App\Events\Renewed;
use App\Events\Canceled;

class SubscriptionChange
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof Started) {
            $type="started";
        } else if ($event instanceof Renewed) {
            $type="renewed";
        } else if ($event instanceof Canceled) {
            $type="cenceled";
        }
        // Log::info('event triggered');
        // do stuff of post request

        $uID = $event->device_details->uID; //device id
        $appID = $event->device_details->appID; //app id

        $event_type = $type;
        //some 3rd party api
        
        // Http::post('http://localhost:8000/api/thirdparty', [
        //     'uID' => $uID,
        //     'appID' => $appID,
        //     'event_info' => $event_type,
        // ]);
    }
}
