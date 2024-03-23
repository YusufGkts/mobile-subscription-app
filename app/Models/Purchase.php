<?php

namespace App\Models;

use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'receipt',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'subscription_id' => 'integer',
        'receipt' => 'string',
        'status' => PurchaseStatus::class,
    ];
}
