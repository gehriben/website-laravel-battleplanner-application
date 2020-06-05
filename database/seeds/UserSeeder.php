<?php

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin user
        User::create([
            "username" => 'admin',
            "email" => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'admin' => true,
        ]);

        // admin user
        User::create([
            "username" => 'admin1',
            "email" => env('ADMIN_EMAIL') . 1,
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'admin' => false,
        ]);
    }
}
