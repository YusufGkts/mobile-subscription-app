<?php

namespace App\Http\Controllers\Api;

use App\Enums\RequestCacheKeyType;
use App\Enums\SubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStoreRequest;
use App\Models\App;
use App\Models\Device;
use App\Models\Language;
use App\Models\OperatingSystem;
use App\Models\Subscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(RegisterStoreRequest $request)
    {
        $cacheKey = RequestCacheKeyType::REGISTER_CACHE_KEY->value . "_{$request->uuid}_{$request->app_id}";
        $cacheValue = Cache::get($cacheKey);
        $cacheTTL = 60;

        if ($cacheValue === null) {
            return DB::transaction(function () use ($request, $cacheKey, $cacheTTL) {

                $device = Device::query()
                    ->where('uuid', $request->uuid)
                    ->first();

                if ($device === null) {
                    $operatingSystem = OperatingSystem::query()
                        ->where('name', $request->os)
                        ->first();

                    if ($operatingSystem === null) {
                        return response()->json(['message' => 'Operating System not found'], 404);
                    }

                    $language = Language::query()
                        ->where('code', $request->language)
                        ->first();

                    if ($language === null) {
                        return response()->json(['message' => 'Language not found'], 404);
                    }

                    $device = Device::query()
                        ->create([
                            'uuid' => $request->uuid,
                            'operating_system_id' => $operatingSystem->id,
                            'language_id' => $language->id,
                        ]);
                }

                $app = App::query()
                    ->where('id', $request->app_id)
                    ->first();

                if ($app === null) {
                    return response()->json(['message' => 'App not found'], 404);
                }

                $subscription = Subscription::query()
                    ->where('device_id', $device->id)
                    ->where('app_id', $app->id)
                    ->first();

                if ($subscription !== null) {
                    return response()->json(['message' => 'Device already registered for this app'], 422);
                }

                $subscription = Subscription::query()
                    ->create([
                        'device_id' => $device->id,
                        'app_id' => $app->id,
                        'expires_at' => now()->addDays(30),
                        'client_token' => base64_encode($request->getClientIp()) . '_' . Str::random(60),
                        'status' => SubscriptionStatus::STARTED,
                    ]);

                Cache::put($cacheKey, $subscription->client_token, $cacheTTL);

                return response()->json([
                    'status' => 'OK',
                    'client_token' => $subscription->client_token
                ]);
            });
        }

        Cache::put($cacheKey, $cacheValue, $cacheTTL);

        return response()->json([
            'status' => 'OK',
            'client_token' => $cacheValue
        ]);
    }
}
