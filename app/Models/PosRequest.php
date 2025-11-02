<?php

namespace App;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Model;

class PosRequest extends Model
{
    protected $fillable = ['product_id', 'qty','size_id', 'customer_id', 'order'];





    protected static function boot()
    {
        parent::boot();

        static::creating(function ($posRequest) {
            $lastRequest = static::orderBy('id', 'desc')->first();
            if ($lastRequest) {
                // Extract the numeric part of the last order number and increment it
                $orderNumber = '000' . (intval(substr($lastRequest->order, -4)) + 1);
                $posRequest->order = substr($orderNumber, -4); // Get last 4 characters
            } else {
                $posRequest->order = '0001'; // Initial order number
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }
}
