<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'name' => 'Air Mineral',
            'price' => 5000,
            'stock_quantity' => 50,
            'category_id' => 2 // Minuman
        ]);

        Product::create([
            'name' => 'Laptop ASUS',
            'price' => 7500000,
            'stock_quantity' => 10,
            'category_id' => 3 // Elektronik
        ]);

        Product::create([
            'name' => 'Pulpen Pilot',
            'price' => 7000,
            'stock_quantity' => 100,
            'category_id' => 4 // Alat Tulis
        ]);
    }
}
