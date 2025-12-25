<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_Preferences extends Model
{
    //
    use HasFactory;
    protected $table = "user_profile_details";
    protected $fillable = [
       "user_id", "age"	,"gender",	"preferences",	"study_level",	"hobbies", "dorm_id"
    ];
    
}
