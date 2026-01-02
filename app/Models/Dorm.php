<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    protected $table = 'dorms';

<<<<<<< HEAD
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
=======
    // Fillable: all columns that we want to mass assign
    protected $fillable = [
        'name',
        'location',
        'dorm_hotline',
        'number_of_rooms',
        'room_types',
        'owner_id',
        'gender_preference',
        'student_only',
        'expected_marital_status',
        'facilities',
        'latitude',
        'longitude',
        'dorm_images',
        'dorm_owner_name',
        'property_document',
        'owner_passport',
    ];

    // Cast JSON columns to array automatically
    protected $casts = [
        'room_types' => 'array',
        'facilities' => 'array',
        'dorm_images' => 'array',
        'property_document' => 'array',
>>>>>>> afia-branch
    ];
}
