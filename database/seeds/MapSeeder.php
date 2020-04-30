<?php

use App\Models\Map;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapArray = [
          /*Bank*/ ['name'=>"bank",'thumbnail_path'=> "/media/thumbs/bank.jpg", 'is_competitive'=>true],
          /*Border*/ ['name'=>"border",'thumbnail_path'=> "/media/thumbs/border.jpg", 'is_competitive'=>true],
          /*Coastline*/ ['name'=>"coastline",'thumbnail_path'=> "/media/thumbs/coastline.png", 'is_competitive'=>true],
          /*Consulate*/ ['name'=>"consulate",'thumbnail_path'=> "/media/thumbs/consulate.jpg", 'is_competitive'=>true],
          /*Chalet*/ ['name'=>"chalet",'thumbnail_path'=> "/media/thumbs/chalet.jpg", 'is_competitive'=>true],
          /*Clubhouse*/ ['name'=>"clubhouse",'thumbnail_path'=> "/media/thumbs/clubhouse.jpg", 'is_competitive'=>true],
          /*Hereford*/ ['name'=>"hereford",'thumbnail_path'=> "/media/thumbs/hereford.jpg", 'is_competitive'=>true],
          /*Kafe*/ ['name'=>"kafe",'thumbnail_path'=> "/media/thumbs/kafe.jpg", 'is_competitive'=>true],
          /*Oregon*/ ['name'=>"oregon",'thumbnail_path'=> "/media/thumbs/oregon.jpg", 'is_competitive'=>true],
          /*Skyscraper*/ ['name'=>"skyscraper",'thumbnail_path'=> "/media/thumbs/skyscraper.png", 'is_competitive'=>true],
          /*Theme Park*/ ['name'=>"theme park",'thumbnail_path'=> "/media/thumbs/themepark.jpg", 'is_competitive'=>true],
          /*Villa*/ ['name'=>"villa",'thumbnail_path'=> "/media/thumbs/villa.png", 'is_competitive'=>true],
          /*Bartlett*/ ['name'=>"bartlett",'thumbnail_path'=> "/media/thumbs/bartlett.jpg", 'is_competitive'=>false],
          /*Favela*/ ['name'=>"favela",'thumbnail_path'=> "/media/thumbs/favela.png", 'is_competitive'=>false],
          /*House*/ ['name'=>"house",'thumbnail_path'=> "/media/thumbs/house.jpg", 'is_competitive'=>false],
          /*Kanal*/ ['name'=>"kanal",'thumbnail_path'=> "/media/thumbs/kanal.jpg", 'is_competitive'=>false],
          /*Plane*/ ['name'=>"plane",'thumbnail_path'=> "/media/thumbs/plane.jpg", 'is_competitive'=>false],
          /*Tower*/ ['name'=>"tower",'thumbnail_path'=> "/media/thumbs/tower.jpg", 'is_competitive'=>false],
          /*Yacht*/ ['name'=>"yacht",'thumbnail_path'=> "/media/thumbs/yacht.jpg", 'is_competitive'=>false],
        ];

        foreach ($mapArray as $key => $map) {
          Map::create($map); // don't use "insert", it does not set timestamps
        }
    }
}
