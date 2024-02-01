<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pic_id',
        'program_name',
        'start_date',   
        'end_date',
    ];
}
