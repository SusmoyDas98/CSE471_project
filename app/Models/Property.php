<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';   // Change this to your actual table

    public $timestamps = false;        // Since you're not using migrations

    protected $fillable = [
        'title',
        'address',
        'bedrooms',
        'bathrooms',
        'sqft',
        'price',
        'status',
        'tenant_name'
    ];
}