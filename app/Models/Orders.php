<?php

namespace App\Models;

use App\Models\OrderItems;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'reference_number',
        'customer_id',
        'total_amount',
        'payment_status',
        'payment_method',
        'shipping_method',
        'tracking_number',
        'estimated_delivery',
        'pickup_date_time',
        'shipping_amount',
        'order_status',
        'notes',
        'return_refund_status',
        'gcash_transaction_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
