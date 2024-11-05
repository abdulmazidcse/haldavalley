<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name', 
        'customer_id', 
        'total',
        'sale_date'
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

}
