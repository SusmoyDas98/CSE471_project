<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    // No database interaction yet
    // This model exists to respect MVC structure

    /**
     * Return dummy properties for testing
     */
    public static function dummyProperties()
    {
        return [
            [
                'status' => 'active',
                'title' => 'Modern 2BR Apartment',
                'address' => '245 Campus Drive, University District',
                'bed' => 2,
                'bath' => 2,
                'sqft' => 850,
                'price' => '$1,200',
                'price_note' => '/month',
                'icon' => 'building',
                'gradient' => 'linear-gradient(135deg, var(--primary-light), var(--accent))',
            ],
            [
                'status' => 'rented',
                'title' => 'Cozy Studio Near Campus',
                'address' => '128 College Avenue, Downtown',
                'bed' => 1,
                'bath' => 1,
                'sqft' => 500,
                'price' => '$800',
                'price_note' => '/month',
                'icon' => 'home',
                'tenant' => 'Sarah Johnson',
                'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
            ],
            [
                'status' => 'pending',
                'title' => 'Luxury 3BR Townhouse',
                'address' => '567 Oak Street, Suburban Area',
                'bed' => 3,
                'bath' => 2.5,
                'sqft' => 1200,
                'price' => '$1,800',
                'price_note' => '/month',
                'icon' => 'building',
                'gradient' => 'linear-gradient(135deg, #f59e0b, #d97706)',
            ],
        ];
    }
}
