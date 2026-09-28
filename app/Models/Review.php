<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'comment',
        'farmer_response',
        'farmer_response_at',
        'review_date',
    ];

    protected $casts = [
        'review_date' => 'datetime',
        'farmer_response_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
