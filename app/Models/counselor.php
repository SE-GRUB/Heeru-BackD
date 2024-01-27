<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class counselor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'fare',
        'description',
        'rating',
    ];
}
