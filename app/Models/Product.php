<?php

namespace App\Models;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description',
        'product_images',
        'price',
        'stock',
        'warranty',
    ];

    protected $casts = [
        'product_images' => 'array',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specifications', 'product_id', 'spec_id')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function productSpecifications() {
        return $this->hasMany(ProductSpecification::class); // Direct access to pivot table
    }
}
