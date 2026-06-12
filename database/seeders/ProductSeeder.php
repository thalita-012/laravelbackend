<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop Pro',
            'slug' => 'laptop-pro',
            'description' => 'High performance laptop with 16GB RAM',
            'price' => 1299.99,
            'stock' => 15,
            'sku' => 'LAP-PRO-001',
            'active' => true,
        ]);

        Product::create([
            'name' => 'Wireless Mouse',
            'slug' => 'wireless-mouse',
            'description' => 'Ergonomic wireless mouse',
            'price' => 29.99,
            'stock' => 100,
            'sku' => 'MOUSE-001',
            'active' => true,
        ]);

        Product::create([
            'name' => 'USB-C Cable',
            'slug' => 'usb-c-cable',
            'description' => '2 meter USB-C charging cable',
            'price' => 15.99,
            'stock' => 250,
            'sku' => 'CABLE-001',
            'active' => true,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'slug' => 'mechanical-keyboard',
            'description' => 'RGB Mechanical Gaming Keyboard',
            'price' => 149.99,
            'stock' => 50,
            'sku' => 'KEY-MECH-001',
            'active' => true,
        ]);

        Product::create([
            'name' => '4K Monitor',
            'slug' => '4k-monitor',
            'description' => '27 inch 4K Ultra HD Monitor',
            'price' => 499.99,
            'stock' => 20,
            'sku' => 'MON-4K-001',
            'active' => true,
        ]);
    }
}
