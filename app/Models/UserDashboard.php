<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDashboard extends Model
{
    protected $table = 'user_dashboard';  // <-- change to your existing table name
    public $timestamps = false;

    // Safe default fillables
    protected $fillable = [
        'id',
        'username',
        'likes',
        'shares',
        'views'
    ];
}