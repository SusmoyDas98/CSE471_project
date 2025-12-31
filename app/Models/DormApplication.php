<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormApplication extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'dorm_id',
        'user_id',
        'status',
        'message',
    ];

    // Relationship to Dorm
    public function dorms()
    {
        return $this->belongsTo(Dorm::class, 'dorm_id');
    }

    // Relationship to User (dorm seeker)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
