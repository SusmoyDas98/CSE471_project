<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;                 

class Website_Reviews extends Model
{    
    use HasFactory;
    protected $table = "website_reviews";
    protected $fillable = [
        "user_id","user_name",	"message",	"rating",'label', "labeled_at"
    ];
    public $timestamps = false;
    
}
