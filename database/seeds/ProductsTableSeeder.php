<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'traje de prro :)',
            'description' => 'nuevo traje para todo tipo de personas',
            'price' => 199.00,
            'rental' => 99.00,
            'stock' => 20
        ]);
        Product::create([
            'name' => 'traje de gato :)',
            'description' => 'nuevo traje para todo tipo de personas',
            'price' => 299.00,
            'rental' => 59.00,
            'stock' => 30
        ]);
        Product::create([
            'name' => 'traje de zorro :)',
            'description' => 'nuevo traje para todo tipo de personas',
            'price' => 599.00,
            'rental' => 199.00,
            'stock' => 3
        ]);
        Product::create([
            'name' => 'traje de pato :)',
            'description' => 'nuevo traje para todo tipo de personas',
            'price' => 159.00,
            'rental' => 57.00,
            'stock' => 20
        ]);
    }
}
