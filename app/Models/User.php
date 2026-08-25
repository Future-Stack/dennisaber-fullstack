<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'security_code_hash',
        'security_code_expires_at',
        'device_id',
        'device_name',
        'device_bound_at',
        'last_device_activity_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'security_code_hash',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'security_code_expires_at' => 'datetime',
            'device_bound_at' => 'datetime',
            'last_device_activity_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
