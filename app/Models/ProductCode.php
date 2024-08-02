<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'country',
        'product_code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_code', 'product_code');
    }
}
