<?php

namespace App\Models;

use App\PosRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'customer_name',
        'email',
        'phone',
        'city',
        'district',
        'address',
        'description',
        'avatar',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }


}
