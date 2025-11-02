<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{

    protected $table = 'sales_orders';

    protected $fillable = ['shipping','status','dolar_price','total_dinar', 'total_dollar']; 

    public function sales()
    {
        return $this->hasMany(Sale::class, 'sales_order_id');
    }
    
}
