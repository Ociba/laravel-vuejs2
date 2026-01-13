<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'address',
        'profile_image',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    // Scope methods for user types
    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'admin');
    }

    public function scopeSellers($query)
    {
        return $query->where('user_type', 'seller');
    }

    public function scopeBuyers($query)
    {
        return $query->where('user_type', 'buyer');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Check user type methods
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isSeller()
    {
        return $this->user_type === 'seller';
    }

    public function isBuyer()
    {
        return $this->user_type === 'buyer';
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}