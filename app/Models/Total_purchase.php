<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total_purchase extends Model
{
    use HasFactory;

    protected $table = 'total_purchase';

    protected $fillable = [
        'order_tax_total',
        'discount_total',
        'shipping_total',
        'grand_total',
        'status',
        'dolar_price',
        'paid',
        'grand_dinar',
        'paid_dinar'
    ];

    public function purchases()
{
    return $this->hasMany(Purchase::class, 'total_id');
}

}
