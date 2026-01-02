<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website_Reviews extends Model
{
    use HasFactory;

    protected $table = "website_reviews";

    // Mass assignable fields
    protected $fillable = [
        "user_id",
        "message",
        "rating",
        "label",
        "label_markerd_at"
    ];

    // Enable Laravel timestamps (created_at, updated_at)
    public $timestamps = true;

    /**
     * Optional: Define relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
