<?php

use App\Models\Floor;
use App\Models\Map;
use App\Models\Operator;
use App\Models\Gadget;

use Illuminate\Database\Seeder;

class WBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mapArray = [
        /*Fortress*/ ['name'=>"fortress",'thumbsrc'=> "/media/thumbs/fortress.jpg", 'comp'=>true]
      ];

      Map::insert($mapArray);

      $floorArray = [
        /*------------------FORTRESS--------------------------------*/
        /*Fortress First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Fortress/First.png", 'floorNum'=>0, 'map_id'=>Map::byName("fortress")->id],
        /*Fortress Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Fortress/Second.png", 'floorNum'=>1, 'map_id'=>Map::byName("fortress")->id],
        /*Fortress Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Fortress/Roof.png", 'floorNum'=>2, 'map_id'=>Map::byName("fortress")->id]
      ];

      Floor::insert($floorArray);

      $opArray = [
        /*Kaid*/['name'=> "Kaid", 'icon'=> "/media/ops/Kaid.png", 'colour'=> "ad8a5b", 'atk'=> false],
        /*Nomad*/['name'=> "Nomad", 'icon'=> "/media/ops/Nomad.png", 'colour'=> "ad8a5b", 'atk'=> true]
      ];

      Operator::insert($opArray);

      $toolArray = [
        /*Kaid*/['name'=> "Kaid", 'icon'=> "/media/tools/unique/Kaid.png", 'prime'=> true, 'general'=> false],
        /*Nomad*/['name'=> "Nomad", 'icon'=> "/media/tools/unique/Nomad.png", 'prime'=> true, 'general'=> false],

        /*General: Hole*/['name'=> "Hole", 'icon'=> "/media/tools/general/Hole.png", 'prime'=> false, 'general'=> true]
      ];

      Gadget::insert($toolArray);
    }
}
