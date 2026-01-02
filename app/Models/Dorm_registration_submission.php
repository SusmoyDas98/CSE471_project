<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dorm_registration_submission extends Model
{
    use HasFactory;

    protected $table = "dorm_registration_submissions";

    protected $fillable = [
        "owner_id",
        "dorm_owner_name",
        "dorm_hotline",
        "dorm_name",
        "dorm_location",
        "latitude",
        "longitude",
        "number_of_rooms",
        "room_types",
        "owner_national_id",
        "passport",
        "property_ownership_doc",
        "dorm_pictures",
        "status",
        "gender_preference",
        "student_only",
        "expected_marital_status",
        "facilities",
    ];

    public $timestamps = true;

    protected $casts = [
        'room_types' => 'array',
        'dorm_pictures' => 'array', // fixed key
        'facilities' => 'array',
        'property_ownership_doc' => 'array',
    ];  
}
