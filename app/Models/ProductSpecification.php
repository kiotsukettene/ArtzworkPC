<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $fillable = [
        'product_id',
        'spec_id',
        'value',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function specification() {
        return $this->belongsTo(Specification::class, 'spec_id');
    }
}
