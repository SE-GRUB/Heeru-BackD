<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reports extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'title',
        'user_id',
        'category_id',
        'evidence',
        'details',
        'isDone',
        'isProcess'
    ];
  
}
