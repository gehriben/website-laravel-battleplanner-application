<?php

use Illuminate\Database\Seeder;
use App\Models\GameType;

class GameTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $typeArray = [
        ['name'=> "Secure Area"],
        ['name'=> "Hostage"],
        ['name'=> "Bomb"],
      ];

      GameType::insert($typeArray);
    }
}
