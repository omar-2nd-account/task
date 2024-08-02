<?php

namespace Tests\Feature;

use App\Http\Services\GoogleSheetsService;
use Tests\TestCase;

class GoogleSheetsServiceTest extends TestCase
{
    protected $googleSheetsService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->googleSheetsService = new GoogleSheetsService();
    }

    public function testCanFetchOrders()
    {
        $orders = $this->googleSheetsService->getOrders();
        $this->assertIsArray($orders);
        $this->assertNotEmpty($orders);
    }

    public function testCanFetchProducts()
    {
        $products = $this->googleSheetsService->getProducts();
        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
    }
}
