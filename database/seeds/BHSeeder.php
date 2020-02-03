<?php

use App\Models\Floor;
use App\Models\Map;
use App\Models\Operator;
use App\Models\Gadget;

use Illuminate\Database\Seeder;

class BHSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mapArray = [
        /*Outback*/ ['name'=>"outback",'thumbsrc'=> "/media/thumbs/outback.jpg", 'comp'=>true]
      ];

      Map::insert($mapArray);

      $floorArray = [
        /*------------------FORTRESS--------------------------------*/
        /*Outback First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Outback/First.png", 'floorNum'=>0, 'map_id'=>Map::byName("outback")->id],
        /*Outback Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Outback/Second.png", 'floorNum'=>1, 'map_id'=>Map::byName("outback")->id],
        /*Outback Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Outback/Roof.png", 'floorNum'=>2, 'map_id'=>Map::byName("outback")->id]
      ];

      Floor::insert($floorArray);

      $opArray = [
        /*Mozzie*/['name'=> "Mozzie", 'icon'=> "/media/ops/Mozzie.png", 'colour'=> "e60866", 'atk'=> false],
        /*Gridlock*/['name'=> "Gridlock", 'icon'=> "/media/ops/Gridlock.png", 'colour'=> "e60866", 'atk'=> true]
      ];

      Operator::insert($opArray);

      $toolArray = [
        /*Mozzie*/['name'=> "Mozzie", 'icon'=> "/media/tools/unique/Mozzie.png", 'prime'=> true, 'general'=> false],
        /*Gridlock*/['name'=> "Gridlock", 'icon'=> "/media/tools/unique/Gridlock.png", 'prime'=> true, 'general'=> false],
      ];

      Gadget::insert($toolArray);
    }
}
