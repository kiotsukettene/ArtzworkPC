<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'quantity',
        'price',
        'selected'
    ];

    protected $casts = [
        'selected' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}