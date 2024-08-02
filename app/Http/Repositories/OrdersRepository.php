<?php

namespace App\Http\Repositories;

use App\Models\Order;
use App\Models\ProductCode;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class OrdersRepository
{
    public function create( $id, string $client_name, string $phone_number, string $product_code, float $final_price, string $quantity ): Order
    {
        $order = new Order();
        if($id) {
            $order->id = $id;
        }
        $order->client_name = $client_name;
        $order->phone_number = $phone_number;

        $product_code = ProductCode::where('product_code', $product_code)->first();
        if (!$product_code) {
            throw new Exception('Product code not found');
        }

        $order->product_code = $product_code->id;
        $order->final_price = $final_price;
        $order->quantity = $quantity;
        $order->save();

        return $order;
    }

    public function getOrders (): Collection
    {
        return Order::all();
    }

    public function update( Order $order, string $client_name, string $phone_number, string $product_code, float $final_price, string $quantity ): Order
    {
        $order->client_name = $client_name;
        $order->phone_number = $phone_number;

        $product_code = ProductCode::where('product_code', $product_code)->first();
        if (!$product_code) {
            throw new Exception('Product code not found');
        }

        $order->product_code = $product_code->id;
        $order->final_price = $final_price;
        $order->quantity = $quantity;
        $order->save();

        return $order;
    }

    public function search ( string $searchTerm ): Collection
    {
        return Order::where('client_name', 'like', "%$searchTerm%")
            ->orWhere('phone_number', 'like', "%$searchTerm%")
            ->get();
    }
}