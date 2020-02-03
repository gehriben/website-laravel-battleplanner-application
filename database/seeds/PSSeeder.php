<?php

use App\Models\Operator;
use App\Models\Gadget;

use Illuminate\Database\Seeder;

class PSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $opArray = [
        /*Warden*/['name'=> "Warden", 'icon'=> "/media/ops/Warden.png", 'colour'=> "2c3e8c", 'atk'=> false],
        /*Nokk*/['name'=> "Nøkk", 'icon'=> "/media/ops/Nokk.png", 'colour'=> "2c3e8c", 'atk'=> true]
      ];

      Operator::insert($opArray);

      $toolArray = [
        /*Warden*/['name'=> "Warden", 'icon'=> "/media/tools/unique/Warden.png", 'prime'=> true, 'general'=> false],
        /*Nokk*/['name'=> "Nøkk", 'icon'=> "/media/tools/unique/Nokk.png", 'prime'=> true, 'general'=> false],
      ];

      Gadget::insert($toolArray);
    }
}
