<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    //
    use HasFactory;
    protected $table = "dorm";
    protected $fillable = [
       "owner_id"	,"name",	"location",	"dorm_review",	"room_count",	"room_types",	"status"
    ];
    
}
