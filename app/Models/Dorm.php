<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    protected $table = 'dorms';

    protected $fillable = [
        // Foreign key
        'owner_id',

        // Basic info
        'name',
        'dorm_hotline',
        'location',

        // Geo
        'latitude',
        'longitude',

        // Rules / preferences
        'student_only',
        'gender_preference',
        'expected_marital_status',

        // Documents & images
        'owner_passport',
        'property_document',
        'dorm_images',

        // Rooms & facilities
        'number_of_rooms',
        'facilities',
        'room_types',

        // Reviews / ratings
        'dorm_review',
        'dorm_rating',

        // Business fields
        'rent',
        'status',
    ];

    protected $casts = [
        // JSON fields
        'facilities' => 'array',
        'room_types' => 'array',
        'dorm_images' => 'array',
        'property_document' => 'array',
        'dorm_review' => 'array',

        // Numeric fields
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'dorm_rating' => 'decimal:2',
        'rent' => 'decimal:2',
    ];
}
