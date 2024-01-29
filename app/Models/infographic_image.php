<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infographic_image extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'infographic_id',
        'image_path',
    ];
}
