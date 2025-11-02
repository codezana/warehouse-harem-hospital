<?php

namespace App\Models;

use App\PosRequest;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'product_type',
        'name',
        'category_id',
        'subcategory_id',
        'brand_id',
        'supplier_id',
        'user_id',
        'barcode',
        'sku_code',
        'description',
        'quantity', 'minimum_qty',
        'price',
        'sale',
        'type_id',
        'image',


    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
    

    public function type()
    {
        return $this->belongsTo(Type::class);
    }


    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    
}
