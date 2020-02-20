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
          /*Bank*/ ['name'=>"bank",'thumbnail_path'=> "/media/thumbs/bank.jpg", 'comp'=>true],
          /*Border*/ ['name'=>"border",'thumbnail_path'=> "/media/thumbs/border.jpg", 'comp'=>true],
          /*Coastline*/ ['name'=>"coastline",'thumbnail_path'=> "/media/thumbs/coastline.png", 'comp'=>true],
          /*Consulate*/ ['name'=>"consulate",'thumbnail_path'=> "/media/thumbs/consulate.jpg", 'comp'=>true],
          /*Chalet*/ ['name'=>"chalet",'thumbnail_path'=> "/media/thumbs/chalet.jpg", 'comp'=>true],
          /*Clubhouse*/ ['name'=>"clubhouse",'thumbnail_path'=> "/media/thumbs/clubhouse.jpg", 'comp'=>true],
          /*Hereford*/ ['name'=>"hereford",'thumbnail_path'=> "/media/thumbs/hereford.jpg", 'comp'=>true],
          /*Kafe*/ ['name'=>"kafe",'thumbnail_path'=> "/media/thumbs/kafe.jpg", 'comp'=>true],
          /*Oregon*/ ['name'=>"oregon",'thumbnail_path'=> "/media/thumbs/oregon.jpg", 'comp'=>true],
          /*Skyscraper*/ ['name'=>"skyscraper",'thumbnail_path'=> "/media/thumbs/skyscraper.png", 'comp'=>true],
          /*Theme Park*/ ['name'=>"theme park",'thumbnail_path'=> "/media/thumbs/themepark.jpg", 'comp'=>true],
          /*Villa*/ ['name'=>"villa",'thumbnail_path'=> "/media/thumbs/villa.png", 'comp'=>true],
          /*Bartlett*/ ['name'=>"bartlett",'thumbnail_path'=> "/media/thumbs/bartlett.jpg", 'comp'=>false],
          /*Favela*/ ['name'=>"favela",'thumbnail_path'=> "/media/thumbs/favela.png", 'comp'=>false],
          /*House*/ ['name'=>"house",'thumbnail_path'=> "/media/thumbs/house.jpg", 'comp'=>false],
          /*Kanal*/ ['name'=>"kanal",'thumbnail_path'=> "/media/thumbs/kanal.jpg", 'comp'=>false],
          /*Plane*/ ['name'=>"plane",'thumbnail_path'=> "/media/thumbs/plane.jpg", 'comp'=>false],
          /*Tower*/ ['name'=>"tower",'thumbnail_path'=> "/media/thumbs/tower.jpg", 'comp'=>false],
          /*Yacht*/ ['name'=>"yacht",'thumbnail_path'=> "/media/thumbs/yacht.jpg", 'comp'=>false],
        ];

        foreach ($mapArray as $key => $map) {
          Map::create($map); // don't use "insert", it does not set timestamps
        }
    }
}
