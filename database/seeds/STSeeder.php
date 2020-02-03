<?php

use App\Models\Operator;
use App\Models\Gadget;

use Illuminate\Database\Seeder;

class STSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $opArray = [
        /*Wamai*/['name'=> "Wamai", 'icon'=> "/media/ops/Wamai.png", 'colour'=> "69192199", 'atk'=> false],
        /*Kali*/['name'=> "Kali", 'icon'=> "/media/ops/Kali.png", 'colour'=> "69192199", 'atk'=> true]
      ];

      Operator::insert($opArray);

      $toolArray = [
        /*Wamai*/['name'=> "Wamai", 'icon'=> "/media/tools/unique/Wamai.png", 'prime'=> true, 'general'=> false],
        /*Kali*/['name'=> "Kali", 'icon'=> "/media/tools/unique/Kali.png", 'prime'=> true, 'general'=> false],
      ];

      Gadget::insert($toolArray);
    }
}
