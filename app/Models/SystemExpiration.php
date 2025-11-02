<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemExpiration extends Model
{
    protected $fillable = ['expiration_date'];
    protected $table = 'system_expiration';

    
}
