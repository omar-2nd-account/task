<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Repositories\OrdersRepository;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCode;

class OrdersRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected OrdersRepository $ordersRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ordersRepository = new OrdersRepository();
    }

    public function testCreateOrder()
    {
        $product = Product::factory()->create();
        $productCode = ProductCode::factory()->create(['product_id' => $product->id]);

        $order = $this->ordersRepository->create(
            null,
            'John Doe', 
            '123-456-7890', 
            $productCode->product_code, 
            100.99, 
            '1'
        );

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'client_name' => 'John Doe',
            'phone_number' => '123-456-7890',
            'product_code' => $productCode->id,
            'final_price' => 100.99,
            'quantity' => '1',
        ]);
    }

    public function testUpdateOrder()
    {
        $product = Product::factory()->create();
        $productCode = ProductCode::factory()->create(['product_id' => $product->id]);
        $order = Order::factory()->create([
            'client_name' => 'Jane Doe',
            'phone_number' => '987-654-3210',
            'product_code' => $productCode->id,
        ]);

        $updatedOrder = $this->ordersRepository->update(
            $order, 
            'John Smith', 
            '123-456-7890', 
            $productCode->product_code, 
            150.75, 
            '2'
        );

        $this->assertEquals('John Smith', $updatedOrder->client_name);
        $this->assertEquals('123-456-7890', $updatedOrder->phone_number);
        $this->assertEquals($productCode->id, $updatedOrder->product_code);
        $this->assertEquals(150.75, $updatedOrder->final_price);
        $this->assertEquals('2', $updatedOrder->quantity);
    }

    public function testSearchOrders()
    {
        $orders = Order::factory()->count(5)->create([
            'client_name' => 'John Doe',
            'phone_number' => '123-456-7890',
        ]);

        $results = $this->ordersRepository->search('John Doe');

        $this->assertCount(5, $results);
    }
}
