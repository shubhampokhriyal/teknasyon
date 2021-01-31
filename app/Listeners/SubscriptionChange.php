<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Log;

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
        Log::info('event triggered');
        // do stuff of post request
        $uID = $event->device_details['uID']; //device id
        $appID = $event->device_details['appID']; //app id

        $event_type = $event->type;
        //some 3rd party api
        Http::post('http://localhost:8000/api/thirdparty', [
            'uID' => $uID,
            'appID' => $appID,
            'event_info' => $event_type,
        ]);
    }
}
