<?php

use Illuminate\Database\Seeder;
use App\Size;
class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create([
            'description' => 'XXS',
        ]);
        Size::create([
            'description' => 'XS',
        ]);
        Size::create([
            'description' => 'S',
        ]);
        Size::create([
            'description' => 'M',
        ]);
        Size::create([
            'description' => 'L',
        ]);
        Size::create([
            'description' => 'XL',
        ]);
        Size::create([
            'description' => 'XXL',
        ]);
    }
}
