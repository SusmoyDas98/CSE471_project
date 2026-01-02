<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormApplication extends Model
{
    use HasFactory;

    // Table name (migration uses `applications`)
    protected $table = 'applications';

    // Fillable fields for mass assignment (match migration)
    protected $fillable = [
        'dorm_id',
        'user_id',
        'status',
        'applied_at',
        'Student_id',
        'Government_id',
        'Personal_photo',
        'Reference',
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
