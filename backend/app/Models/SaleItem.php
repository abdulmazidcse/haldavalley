<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use SoftDeletes; 
    use HasFactory; 

    protected $fillable = [
        'sale_id',
        'product_id',
        'discount',
        'quantity',
        'cost_price',
        'mrp_price',
        'total',
    ];

    // Relationship with Sales
    public function sale()
    {
        return $this->belongsTo(Sales::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
