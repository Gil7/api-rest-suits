<?php

use Illuminate\Database\Seeder;
use App\Size;
class SizsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create([
            'name' => 'XXS',
        ]);
        Size::create([
            'name' => 'XS',
        ]);
        Size::create([
            'name' => 'S',
        ]);
        Size::create([
            'name' => 'M',
        ]);
        Size::create([
            'name' => 'L',
        ]);
        Size::create([
            'name' => 'XL',
        ]);
        Size::create([
            'name' => 'XXL',
        ]);
    }
}
