<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Services\DeviceService;
use Log;

class DeviceController extends Controller
{
    public function __construct(DeviceService $deviceservice)
    {
        $this->deviceservice = $deviceservice;
    }
    // Device registration
    public function create(Request $request) {
        try {
            return $this->deviceservice->addDevice($request);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
    
    public function thirdparty(Request $request) {
        Log::info("third-party");
        Log::info(response()->json($request, 200));
    }

}
