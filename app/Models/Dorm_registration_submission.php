<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dorm_registration_submission extends Model
{

    //
    use HasFactory;
    protected $table = "dorm_registration_submissions";
    protected $fillable = [
        "owner_id",	"dorm_owner_name",	"phone_number"	,"dorm_name"	,"dorm_location",	"number_of_rooms",	"room_types"	,"owner_nid",	"owner_passport","property_document",	"dorm_images", "status"
    ];
    public $timestamps = false;
    protected $casts = [
        'room_types' => 'array',
        'dorm_images' => 'array',
    ];  
}
