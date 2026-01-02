<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_Model extends Model
{
    //
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
<<<<<<< HEAD
       "name", "email","password","google_id","google_token","google_refresh_token","role", "subscription_type", "subscription_exp"
=======
       "name", "email","password","role", "subscription_type", "subscription_exp"
>>>>>>> afia-branch
    ];
    
}
