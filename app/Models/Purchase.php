<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';

    protected $fillable = [
        'product_id',
        'quantity',
        'purchase_price',
        'sale_price',
        'reference',
        'date',
        'expire_date',
        'supplier_id',
        'total_cost',
        'total_id',
        'biller_id'


    ];


    public function biller()
    {
        return $this->belongsTo(User::class, 'biller_id');
    }

    
    public function totalPurchase()
    {
        return $this->belongsTo(Total_purchase::class, 'total_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    
    
}
