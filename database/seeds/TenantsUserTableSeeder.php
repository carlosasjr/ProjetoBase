<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class TenantsUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com.br',
            'password' => bcrypt('123mudar')
        ]);
    }
}
