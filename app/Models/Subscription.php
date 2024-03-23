<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'app_id',
        'client_token',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'device_id' => 'integer',
        'app_id' => 'integer',
        'client_token' => 'string',
        'status' => SubscriptionStatus::class,
        'expires_at' => 'timestamp',
    ];
}
