<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['type_name', 'description'];

    // Automatically increment type_code when creating a new type
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($type) {
            $lasttype = static::orderBy('id', 'desc')->first();
            if ($lasttype) {
                $type->type_code = 'BX' . str_pad((int)substr($lasttype->type_code, 2) + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $type->type_code = 'BX00';
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'type_id');
    }
}