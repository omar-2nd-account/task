<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\GoogleSheetsService;
use App\Http\Repositories\OrdersRepository;
use App\Http\Repositories\ProductsRepository;
use App\Models\ProductCode;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Validator;


class UpdateDatabaseFromGoogleSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-database-from-google-sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected GoogleSheetsService $googleSheetsService,
        protected OrdersRepository $ordersRepository,
        protected ProductsRepository $productsRepository
    )
    {  
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = $this->googleSheetsService->getOrders();
        $products = $this->googleSheetsService->getProducts();

        foreach ($products as $product) {

            $checkProduct = ProductCode::where('product_code', $product[3])->first();

            if (!$checkProduct) {
                try {
                    $newProduct = $this->productsRepository->create($product[0], $product[1]);
                    $productCode = new ProductCode();
                    $productCode->product_code = $product[3];
                    $productCode->country = $product[2];
                    $productCode->product()->associate($newProduct);
                    $productCode->save();
                } catch (Exception $e) {
                    $this->error("Failed to create product: $product[3], skipping \n $e");
                }
                continue;
            }

            try {
                $this->productsRepository->update($checkProduct->product, $product[0], $product[1]);
            } catch (Exception $e) {
                $this->error("Failed to update product: $product[3], skipping \n $e");
            }
        }

        foreach ($orders as $order) {

            if (!$this->validateOrder($order)) {
                $this->error("Invalid order: $order[0], skipping");
                continue;
            }

            try {
                $order[4] = (float) $order[4];
            } catch (Exception $e) {
                $this->error("Invalid price for order: $order[0], skipping \n $e");
                continue;
            }

            $checkOrder = Order::where('id', $order[0])
                ->first();
            
            if ($checkOrder) {
                try {
                    $this->ordersRepository->update($checkOrder, $order[1], $order[2], $order[3], $order[4], $order[5]);
                } catch (Exception $e) {
                    $this->error("Failed to update order: $order[0], skipping \n $e");
                }

                continue;
            } 

            try {
                $this->ordersRepository->create($order[0], $order[1], $order[2], $order[3], $order[4], $order[5]);
            } catch (Exception $e) {
                $this->error("Failed to create order: $order[0], skipping \n $e");
            }
        }
    }

    public function validateOrder(array $order): bool
    {
        $validator = Validator::make([
            'id' => $order[0],
            'client_name' => $order[1],
            'phone_number' => $order[2],
            'product_code' => $order[3],
            'final_price' => $order[4],
            'quantity' => $order[5],
        ], [
            'id' => 'required|string',
            'client_name' => 'required|string',
            'phone_number' => 'required|string',
            'product_code' => 'required|string',
            'final_price' => 'required|string',
            'quantity' => 'required|string',
        ]);

        return !$validator->fails();
    }
}
