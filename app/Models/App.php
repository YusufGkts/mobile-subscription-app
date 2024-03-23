<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password'
    ];

    protected $casts = [
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
    ];
}
