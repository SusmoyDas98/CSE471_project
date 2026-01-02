<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city',
        'nearby_university',
        'description',
        'amenities',
        'rules',
        'photos',
        'contact_phone',
        'contact_email',
    ];

    protected $casts = [
        'amenities' => 'array',
        'rules' => 'array',
        'photos' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('joined_at');
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }
}

