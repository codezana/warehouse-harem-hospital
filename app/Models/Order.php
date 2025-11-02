<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table="pos_requests";

    
    protected $fillable = ['product_id', 'qty','size_id', 'customer_id', 'order','receipt','request_id','is_active'];



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function userorder()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    
}
