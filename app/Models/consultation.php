<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'counselor_id',
        'consultation_date',
        'duration',
        'note',
        'isPaid'
    ];
}
