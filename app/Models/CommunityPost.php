<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'dorm_id',
        'user_id',
        'body',
        'parent_id',
    ];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(CommunityPost::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(CommunityPost::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function isReply()
    {
        return $this->parent_id !== null;
    }
}
