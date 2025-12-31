<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'dorms';

    // Fillable fields
    protected $fillable = [
        'name',
        'location',
        'room_count',
        'room_types',
        'owner_id',
    ];
}
