<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'size_id',
        'quantity',
        'price',
        'discount',
        'subtotal',
        'customer_id',
        'user_id',
        'date',
        'receipt',
        'biller_id',
        'sales_order_id',
        'invoice_id'

    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
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
    public function Invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }


    
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

}
