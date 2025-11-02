<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $table='category';

   protected $fillable = [
    'name',
    'description',
    'product_image',
    'category_code',
    'user_id',
    
];



protected static function boot()
{
    parent::boot();

    static::creating(function ($category) {
        $lastCategory = static::orderBy('id', 'desc')->first();
        if ($lastCategory) {
            // Extract the numeric part of the last category code and increment it
            $lastCategoryNumber = intval(substr($lastCategory->category_code, 2)); // Extract numeric part
            $nextCategoryNumber = $lastCategoryNumber + 1;
            $category->category_code = 'CT' . str_pad($nextCategoryNumber, 3, '0', STR_PAD_LEFT); // Format with leading zeros
        } else {
            $category->category_code = 'CT000'; // Initial category code
        }
    });
}


public function createdBy()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function subcategories()
{
    return $this->hasMany(Subcategory::class);
}
public function products()
{
    return $this->hasMany(Product::class, 'category_id');
}

}
