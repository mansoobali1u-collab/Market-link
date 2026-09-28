<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = [
        'market_name',
        'address',
        'operating_days',
        'timings',
        'latitude',
        'longitude',
    ];

    public function farmers()
    {
        return $this->hasMany(User::class, 'market_id');
    }
}
