<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DormRegistrationSubmission extends Model
{
    protected $fillable = [
        'dorm_name',
        'dorm_location',
        'room_count',
        'room_types',
        'description',
        'owner_id',
        'dorm_owner_name',
        'dorm_owner_email',
        'submitted_at',
        'reviewed_at',
        'status', // added
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public $timestamps = false; // no created_at / updated_at

    // Relation to owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
