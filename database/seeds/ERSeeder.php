<?php

use App\Models\Operator;
use App\Models\Gadget;

use Illuminate\Database\Seeder;

class ERSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $opArray = [
        /*Goyo*/['name'=> "Goyo", 'icon'=> "/media/ops/Goyo.png", 'colour'=> "156510", 'atk'=> false],
        /*Amaru*/['name'=> "Amaru", 'icon'=> "/media/ops/Amaru.png", 'colour'=> "156510", 'atk'=> true]
      ];

      Operator::insert($opArray);

      $toolArray = [
        /*Goyo*/['name'=> "Goyo", 'icon'=> "/media/tools/unique/Goyo.png", 'prime'=> true, 'general'=> false],
        /*Amaru*/['name'=> "Amaru", 'icon'=> "/media/tools/unique/Amaru.png", 'prime'=> true, 'general'=> false],
      ];

      Gadget::insert($toolArray);
    }
}
