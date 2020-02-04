<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'name' => 'suporte',
           'email' => 'suporte@theplace.com.br',
           'password' => bcrypt('pl4c32k@16')
        ]);
    }
}
