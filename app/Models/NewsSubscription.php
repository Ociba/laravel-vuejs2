<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsSubscription extends Model
{
    protected $fillable = ['email','ip_address','user_agent','is_verified','subscription_token'];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
