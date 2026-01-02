<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoommateConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id',
        'selected_roommate_id',
        'status',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function selectedRoommate()
    {
        return $this->belongsTo(User::class, 'selected_roommate_id');
    }
}
