<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                    'first_name' => 'super',
                    'last_name' => 'admin',
                    'email' => 'super_admin@app.com',
                    'password' => bcrypt('123456')
                ]);
        $user->attachRole('super_admin');

        $user = User::create([
            'first_name' => 'mohamed',
            'last_name' => 'elfert',
            'email' => 'mohamed@yahoo.com',
            'password' => bcrypt('123456')
        ]);
        $user->attachRole('admin');
    }
}
