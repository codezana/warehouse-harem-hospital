<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table='subcategory';

    protected $fillable = ['name', 'description', 'subcategory_image', 'subcategory_code', 'parent_category_id'];


    protected static function boot()
{
    parent::boot();

    static::creating(function ($subcategory) {
        $lastsubcategory = static::orderBy('id', 'desc')->first();
        if ($lastsubcategory) {
            // Extract the numeric part of the last subcategory code and increment it
            $lastsubcategoryNumber = intval(substr($lastsubcategory->subcategory_code, 2)); // Extract numeric part
            $nextsubcategoryNumber = $lastsubcategoryNumber + 1;
            $subcategory->subcategory_code = 'SB' . str_pad($nextsubcategoryNumber, 3, '0', STR_PAD_LEFT); // Format with leading zeros
        } else {
            $subcategory->subcategory_code = 'SB000'; // Initial category code
        }
    });
}

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
