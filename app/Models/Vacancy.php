<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'status',
        'available_from',
        'available_to',
        'notes',
    ];

    protected $casts = [
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function dorm()
    {
        return $this->room?->dorm;
    }
}

