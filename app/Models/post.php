<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'post_body',   
        'poster',
        'like',
        'isAnonymous',
        'isVerified'
    ];
}
