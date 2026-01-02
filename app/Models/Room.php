<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'dorm_id',
        'label',
        'capacity',
        'price',
        'room_type',
        'is_shared',
        'size_sqft',
        'gender_policy',
        'available_from',
    ];

    protected $casts = [
        'is_shared' => 'boolean',
        'available_from' => 'date',
    ];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }
}

