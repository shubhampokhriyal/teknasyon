<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Started
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $device_details;
    public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($device_details)
    {
        $this->device_details = $device_details;
        $this->type = 'Started';
    }
}
