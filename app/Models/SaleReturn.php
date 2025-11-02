<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    protected $table = 'sale_return';

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'date',
        'receipt',
        'biller_id',
        'customer_id',
        'user_id',
        'sales_order_id'

    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SaleReturnOrder::class, 'sales_order_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function biller()
    {
        return $this->belongsTo(User::class, 'biller_id');
    }

    public function salesuser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
