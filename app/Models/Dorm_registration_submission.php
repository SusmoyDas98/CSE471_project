<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dorm_registration_submission extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $table = "dorm_registration_submissions";

=======

    //
    use HasFactory;
    protected $table = "dorm_registration_submissions";
>>>>>>> afia-branch
    protected $fillable = [
        "owner_id",
        "dorm_owner_name",
        "dorm_hotline",
        "dorm_name",
        "dorm_location",
        "latitude",
        "longitude",
        "number_of_rooms",
<<<<<<< HEAD
        "room_types",
        "owner_national_id",
        "passport",
        "property_ownership_doc",
        "dorm_pictures",
        "status",
=======
        "status",
        "room_types",
>>>>>>> afia-branch
        "gender_preference",
        "student_only",
        "expected_marital_status",
        "facilities",
<<<<<<< HEAD
    ];

    public $timestamps = true;

    protected $casts = [
        'room_types' => 'array',
        'dorm_pictures' => 'array', // fixed key
        'facilities' => 'array',
        'property_ownership_doc' => 'array',
    ];  
}
=======
        "owner_national_id",
        "passport",
        "property_ownership_doc",
        "dorm_pictures"
    ];

    public $timestamps = true;
    protected $casts = [
        'room_types' => 'array',
        'facilities' => 'array',
        'property_ownership_doc' => 'array',
        'dorm_pictures' => 'array'
    ];  
}
>>>>>>> afia-branch
