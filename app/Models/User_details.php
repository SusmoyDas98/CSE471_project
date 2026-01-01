<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_details extends Model
{
    use HasFactory;
    protected $table = 'user_profile_details';
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'contact_number',
        'preferences',
        'hobbies',
        'student',
        'profession',
        'marital_status',
        'dorm_id',
    ];
    protected $casts = [
        'preferences' => 'array',
        'hobbies'     => 'array',
    ];

    
}
