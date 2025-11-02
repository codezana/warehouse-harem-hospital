<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'supplier_name',
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


public function purchases()
{
    return $this->hasMany(Purchase::class);
}
}
