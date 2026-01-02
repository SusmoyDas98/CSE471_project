<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'bio',
        'profession',
        'verification_document',
        'budget_min',
        'budget_max',
        'move_in_date',
        'stay_length_months',
        'room_type_pref',
        'gender_pref',
        'marital_status',
        'smoking',
        'pet_friendly',
        'cleanliness_level',
        'noise_tolerance',
        'wake_time',
        'sleep_time',
        'study_habits',
        'languages',
        'interests',
        'location_priority',
        'amenities_priority',
        'has_roommate',
        'roommate_count',
        'preferred_areas',
    ];

    protected $casts = [
        'smoking' => 'boolean',
        'pet_friendly' => 'boolean',
        'has_roommate' => 'boolean',
        'languages' => 'array',
        'interests' => 'array',
        'amenities_priority' => 'array',
        'preferred_areas' => 'array',
        'move_in_date' => 'date',
        'wake_time' => 'datetime:H:i',
        'sleep_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
