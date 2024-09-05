<?php

    namespace Database\Seeders;

    use App\Models\Product;
    use Illuminate\Database\Seeder;

    class ProductsSeed extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $products = [
                [
                    'product1', 100, 10
                ], [
                    'product1', 100, 10
                ], [
                    'product1', 200, 10
                ], [
                    'product1', 300, 10
                ], [
                    'product1', 400, 10
                ], [
                    'product1', 500, 10
                ], [
                    'product1', 600, 10
                ], [
                    'product1', 700, 10
                ]
            ];
            foreach ($products as $product) {
                Product::create([
                    'name' => $product[0],
                    'price' => $product[1],
                    'stock' => $product[2],
                ]);
            }
        }
    }
