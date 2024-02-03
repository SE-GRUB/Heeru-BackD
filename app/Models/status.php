<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    use HasFactory;
    protected $table = 'status'; // Assuming your table name is 'status'

    protected $fillable = [
        'report_id',
        'user_id',
        'status',
        'note',
   
    ];
}
