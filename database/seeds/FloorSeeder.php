<?php

use App\Models\Floor;
use App\Models\Map;

use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $floorArray = [
        /*------------------BANK--------------------------------*/
        /*Bank Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Bank/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("bank")->id],
        /*Bank First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Bank/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("bank")->id],
        /*Bank Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Bank/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("bank")->id],
        /*Bank Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Bank/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("bank")->id],

        /*------------------BORDER--------------------------------*/
        /*Border First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Border/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("border")->id],
        /*Border Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Border/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("border")->id],
        /*Border Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Border/Roof.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("border")->id],

        /*------------------COASTLINE--------------------------------*/
        /*Coastline First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Coastline/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("coastline")->id],
        /*Coastline Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Coastline/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("coastline")->id],
        /*Coastline Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Coastline/Roof.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("coastline")->id],

        /*------------------CONSULATE--------------------------------*/
        /*Consulate Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Consulate/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("consulate")->id],
        /*Consulate First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Consulate/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("consulate")->id],
        /*Consulate Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Consulate/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("consulate")->id],
        /*Consulate Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Consulate/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("consulate")->id],

        /*------------------CHALET--------------------------------*/
        /*Chalet Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Chalet/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("chalet")->id],
        /*Chalet First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Chalet/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("chalet")->id],
        /*Chalet Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Chalet/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("chalet")->id],
        /*Chalet Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Chalet/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("chalet")->id],

        /*------------------CLUBHOUSE--------------------------------*/
        /*Clubhouse Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Clubhouse/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("clubhouse")->id],
        /*Clubhouse First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Clubhouse/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("clubhouse")->id],
        /*Clubhouse Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Clubhouse/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("clubhouse")->id],
        /*Clubhouse Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Clubhouse/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("clubhouse")->id],

        /*------------------KAFE--------------------------------*/
        /*Kafe First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Kafe/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("kafe")->id],
        /*Kafe Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Kafe/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("kafe")->id],
        /*Kafe Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Kafe/Third.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("kafe")->id],
        /*Kafe Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Kafe/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("kafe")->id],

        /*------------------OREGON--------------------------------*/
        /*Oregon Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Oregon/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("oregon")->id],
        /*Oregon First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Oregon/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("oregon")->id],
        /*Oregon Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Oregon/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("oregon")->id],
        /*Oregon Tower*/ ['name'=> "tower", 'src'=> "/media/maps/Clean/Oregon/Tower.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("oregon")->id],

        /*------------------SKYSCRAPER--------------------------------*/
        /*Skyscraper First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Skyscraper/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("skyscraper")->id],
        /*Skyscraper Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Skyscraper/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("skyscraper")->id],
        /*Skyscraper Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Skyscraper/Roof.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("skyscraper")->id],

        /*------------------VILLA--------------------------------*/
        /*Villa Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Villa/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("villa")->id],
        /*Villa First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Villa/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("villa")->id],
        /*Villa Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Villa/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("villa")->id],

        /*------------------THEME PARK--------------------------------*/
        /*Theme Park First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Theme Park/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("theme park")->id],
        /*Theme Park Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Theme Park/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("theme park")->id],
        /*Theme Park Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Theme Park/Roof.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("theme park")->id],

        /*------------------HOUSE--------------------------------*/
        /*House Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/House/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("house")->id],
        /*House First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/House/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("house")->id],
        /*House Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/House/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("house")->id],
        /*House Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/House/Roof.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("house")->id],

        /*------------------YACHT--------------------------------*/
        /*Yacht Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Yacht/Basement.png", 'floorNum'=>0, 'map_id'=>Map::byName("yacht")->id],
        /*Yacht First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Yacht/First.png", 'floorNum'=>1, 'map_id'=>Map::byName("yacht")->id],
        /*Yacht Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Yacht/Second.png", 'floorNum'=>2, 'map_id'=>Map::byName("yacht")->id],
        /*Yacht Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Yacht/Third.png", 'floorNum'=>3, 'map_id'=>Map::byName("yacht")->id],
        /*Yacht Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Yacht/Roof.png", 'floorNum'=>4, 'map_id'=>Map::byName("yacht")->id],

        /*------------------FAVELA--------------------------------*/
        /*Favela First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Favela/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("favela")->id],
        /*Favela Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Favela/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("favela")->id],
        /*Favela Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Favela/Third.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("favela")->id],
        /*Favela Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Favela/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("favela")->id],

        /*------------------TOWER--------------------------------*/
        /*Tower First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Tower/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("tower")->id],
        /*Tower Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Tower/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("tower")->id],
        /*Tower Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Tower/Third.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("tower")->id],
        /*Tower Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Tower/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("tower")->id],

        /*------------------PLANE--------------------------------*/
        /*Plane Cargo*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Plane/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("plane")->id],
        /*Plane First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Plane/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("plane")->id],
        /*Plane Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Plane/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("plane")->id],
        /*Plane Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Plane/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("plane")->id],

        /*------------------BARTLETT--------------------------------*/
        /*Bartlett First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Bartlett/First.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("bartlett")->id],
        /*Bartlett Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Bartlett/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("bartlett")->id],
        /*Bartlett Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Bartlett/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("bartlett")->id],

        /*------------------HEREFORD--------------------------------*/
        /*Hereford Basement*/ ['name'=> "basement", 'src'=> "/media/maps/Clean/Hereford/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("hereford")->id],
        /*Hereford First*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Hereford/First.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("hereford")->id],
        /*Hereford Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Hereford/Second.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("hereford")->id],
        /*Hereford Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Hereford/Third.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("hereford")->id],
        /*Hereford Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Hereford/Roof.jpg", 'floorNum'=>4, 'map_id'=>Map::byName("hereford")->id],

        /*------------------KANAL--------------------------------*/
        /*Kanal Basement*/ ['name'=> "first", 'src'=> "/media/maps/Clean/Kanal/Basement.jpg", 'floorNum'=>0, 'map_id'=>Map::byName("kanal")->id],
        /*Kanal Second*/ ['name'=> "second", 'src'=> "/media/maps/Clean/Kanal/Second.jpg", 'floorNum'=>1, 'map_id'=>Map::byName("kanal")->id],
        /*Kanal Third*/ ['name'=> "third", 'src'=> "/media/maps/Clean/Kanal/Third.jpg", 'floorNum'=>2, 'map_id'=>Map::byName("kanal")->id],
        /*Kanal Roof*/ ['name'=> "roof", 'src'=> "/media/maps/Clean/Kanal/Roof.jpg", 'floorNum'=>3, 'map_id'=>Map::byName("kanal")->id],
      ];

      foreach ($floorArray as $key => $floor) {
        Floor::create($floor); // don't use "insert", it does not set timestamps
      }
    }
}
