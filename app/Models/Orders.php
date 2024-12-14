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
        'gcash_transaction_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
