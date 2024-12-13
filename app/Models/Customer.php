<?php

namespace App\Models;

use App\Models\CustomerAddresses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'gender',
        'birthday',
        'phone',
        'email_address',
        'default_address_id',
        'profile_picture',
        'password',
        'created_by',
        'updated_by'
    ];

    // Relationship with CustomerAddress
    public function addresses()
    {
        return $this->hasMany(CustomerAddresses::class);
    }

    // Relationship with default address
    public function defaultAddress()
    {
        return $this->belongsTo(CustomerAddresses::class, 'default_address_id');
    }

    // Helper method to get full name
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
