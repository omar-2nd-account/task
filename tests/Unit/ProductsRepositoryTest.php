<?php

namespace Tests\Unit\Repositories;

use App\Http\Repositories\ProductsRepository;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $productsRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productsRepository = new ProductsRepository();
    }

    public function it_can_create_a_product()
    {
        $name = 'Sample Product';
        $description = 'This is a sample product description.';

        $product = $this->productsRepository->create($name, $description);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $name,
            'description' => $description,
        ]);
    }

    public function it_can_update_a_product()
    {
        $product = Product::factory()->create([
            'name' => 'Old Product Name',
            'description' => 'Old description',
        ]);

        $newName = 'Updated Product Name';
        $newDescription = 'Updated description';

        $updatedProduct = $this->productsRepository->update($product, $newName, $newDescription);

        $this->assertInstanceOf(Product::class, $updatedProduct);
        $this->assertEquals($newName, $updatedProduct->name);
        $this->assertEquals($newDescription, $updatedProduct->description);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $newName,
            'description' => $newDescription,
        ]);
    }

    public function it_can_get_all_products()
    {
        Product::factory()->count(5)->create();

        $products = $this->productsRepository->getProducts();

        $this->assertCount(5, $products);
    }
}
