<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'operating_system_id',
        'language_id',
    ];

    protected $casts = [
        'uuid' => 'string',
        'operating_system_id' => 'integer',
        'language_id' => 'integer',
    ];
}
