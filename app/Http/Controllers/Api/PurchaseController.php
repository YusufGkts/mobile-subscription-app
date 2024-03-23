<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseStoreRequest;
use App\Models\Device;
use App\Models\OperatingSystem;
use App\Models\Purchase;
use App\Models\Subscription;

class PurchaseController extends Controller
{
    public function store(PurchaseStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $subscription = Subscription::query()
            ->where('client_token', $request->client_token)
            ->first();

        if ($subscription === null) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        $device = Device::query()
            ->where('id', $subscription->device_id)
            ->first();

        if ($device === null) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $operatingSystem = OperatingSystem::query()
            ->where('id', $device->operating_system_id)
            ->first();

        if ($operatingSystem === null) {
            return response()->json(['message' => 'Operating System not found'], 404);
        }

        $apiData = $this->checkPurchaseFromApi($operatingSystem->name, $request->receipt);

        if (!$apiData['status']) {
            return response()->json(['message' => $apiData['message']], $apiData['statusCode']);
        }

        $purchase = Purchase::query()
            ->where('receipt', $request->receipt)
            ->first();

        if ($purchase) {
            $purchase->update([
                'status' => $apiData['purchaseStatus'],
                'expires_at' => $apiData['expireDate']
            ]);
        } else {
            $purchase = Purchase::query()
                ->create([
                    'subscription_id' => $subscription->id,
                    'receipt' => $request->receipt,
                    'status' => $apiData['purchaseStatus'],
                    'expires_at' => $apiData['expireDate']
                ]);
        }

        return response()->json(
            [
                'status' =>  'OK',
            ],
        );
    }

    public function checkPurchaseFromApi($operatingSystemName, $receipt)
    {
        $apiService = 'App\\Services' . '\\' . ucfirst($operatingSystemName) . 'ApiService';

        if (!class_exists($apiService)) {
            return response()->json(['message' => 'Purchase API not found'], 404);
        }

        $apiService = new $apiService();

        return $apiService->checkReceipt($receipt);
    }

}
