<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionCheckRequest;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function checkSubscription(SubscriptionCheckRequest $request): \Illuminate\Http\JsonResponse
    {
        $subscription = Subscription::query()
            ->where('client_token', $request->client_token)
            ->first();

        if ($subscription === null) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }
        return response()->json(
            [
                'status' => $subscription->status->value,
                'message' => $subscription->status->name,
                'expire_date' => $subscription->expires_at,
            ]
        );
    }
}
