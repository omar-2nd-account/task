<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductsRepository
{
    public function create( string $name, string $description ): Product
    {
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->save();

        return $product;
    }

    public function update( Product $product, string $name, string $description ): Product
    {
        $product->name = $name;
        $product->description = $description;
        $product->save();

        return $product;
    }

    public function getProducts (): Collection
    {
        return Product::all();
    }
}