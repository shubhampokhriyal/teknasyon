<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function __construct(SubscriptionService $subscriptionservice)
    {
        $this->subscriptionservice = $subscriptionservice;
    }
    // For purchase request
    public function purchase(Request $request) {
        try {
            return $this->subscriptionservice->addSubscription($request);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
    // For checking the subscription
    public function checkSubscription(Request $request) {
        try {
            return $this->subscriptionservice->checkSubscription($request);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
    // For cron jobs
    public function updateSubscriptionStatus() {
        try {
            return $this->subscriptionservice->updateSubscriptionStatus();
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
