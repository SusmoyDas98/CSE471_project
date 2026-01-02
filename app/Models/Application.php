<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id',
        'user_id',
        'message',
        'budget',
        'move_in_date',
        'status',
        'owner_notes',
    ];

    protected $casts = [
        'move_in_date' => 'date',
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function seeker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

