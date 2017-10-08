<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'Gilberto',
           'lastname' => 'Mendez Santiz',
           'username' => 'gilberto1',
           'email' => 'gilberto@gmail.com',
           'phone' => '9614561234',
           'isAdmin' => true,
            'password' => bcrypt('gilberto')
        ]);
        User::create([
            'name' => 'Fulanito',
            'lastname' => 'sin apellido',
            'username' => 'fulanito1',
            'email' => 'fulanito@gmail.com',
            'phone' => '9615661234',
            'isAdmin' => false,
            'password' => bcrypt('fulanito')
        ]);
    }
}
