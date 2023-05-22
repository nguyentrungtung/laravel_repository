<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;
    protected $fillable = [
        'old_link' , 'new_link' , 'redirect_status', 'status',
    ];
}
