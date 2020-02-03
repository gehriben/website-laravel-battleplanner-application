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
            "email" => 'admin@tavernsidepodcast.com',
            'password' => bcrypt('r6-tavs-admin'),
        ]);
    }
}
