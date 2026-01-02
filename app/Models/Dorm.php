<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    protected $table = 'dorms';

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
    ];
}
