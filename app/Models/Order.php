<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'phone_number',
        'product_code',
        'final_price',
    ];

    public function productCode()
    {
        return $this->belongsTo(ProductCode::class, 'product_code', 'id');
    }

    public function product()
    {
        return $this->hasOneThrough(Product::class, ProductCode::class, 'id', 'id', 'product_code', 'product_id');
    }
}
