<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adcharge extends Model
{
    protected $fillable = ['offer','charge', 'is_trial_eligible','status'];

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
