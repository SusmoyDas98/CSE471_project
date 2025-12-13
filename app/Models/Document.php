<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'applications';

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
}
