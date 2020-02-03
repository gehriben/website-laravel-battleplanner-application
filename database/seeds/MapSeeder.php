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
          /*Bank*/ ['name'=>"bank",'thumbsrc'=> "/media/thumbs/bank.jpg", 'comp'=>true],
          /*Border*/ ['name'=>"border",'thumbsrc'=> "/media/thumbs/border.jpg", 'comp'=>true],
          /*Coastline*/ ['name'=>"coastline",'thumbsrc'=> "/media/thumbs/coastline.png", 'comp'=>true],
          /*Consulate*/ ['name'=>"consulate",'thumbsrc'=> "/media/thumbs/consulate.jpg", 'comp'=>true],
          /*Chalet*/ ['name'=>"chalet",'thumbsrc'=> "/media/thumbs/chalet.jpg", 'comp'=>true],
          /*Clubhouse*/ ['name'=>"clubhouse",'thumbsrc'=> "/media/thumbs/clubhouse.jpg", 'comp'=>true],
          /*Hereford*/ ['name'=>"hereford",'thumbsrc'=> "/media/thumbs/hereford.jpg", 'comp'=>true],
          /*Kafe*/ ['name'=>"kafe",'thumbsrc'=> "/media/thumbs/kafe.jpg", 'comp'=>true],
          /*Oregon*/ ['name'=>"oregon",'thumbsrc'=> "/media/thumbs/oregon.jpg", 'comp'=>true],
          /*Skyscraper*/ ['name'=>"skyscraper",'thumbsrc'=> "/media/thumbs/skyscraper.png", 'comp'=>true],
          /*Theme Park*/ ['name'=>"theme park",'thumbsrc'=> "/media/thumbs/themepark.jpg", 'comp'=>true],
          /*Villa*/ ['name'=>"villa",'thumbsrc'=> "/media/thumbs/villa.png", 'comp'=>true],
          /*Bartlett*/ ['name'=>"bartlett",'thumbsrc'=> "/media/thumbs/bartlett.jpg", 'comp'=>false],
          /*Favela*/ ['name'=>"favela",'thumbsrc'=> "/media/thumbs/favela.png", 'comp'=>false],
          /*House*/ ['name'=>"house",'thumbsrc'=> "/media/thumbs/house.jpg", 'comp'=>false],
          /*Kanal*/ ['name'=>"kanal",'thumbsrc'=> "/media/thumbs/kanal.jpg", 'comp'=>false],
          /*Plane*/ ['name'=>"plane",'thumbsrc'=> "/media/thumbs/plane.jpg", 'comp'=>false],
          /*Tower*/ ['name'=>"tower",'thumbsrc'=> "/media/thumbs/tower.jpg", 'comp'=>false],
          /*Yacht*/ ['name'=>"yacht",'thumbsrc'=> "/media/thumbs/yacht.jpg", 'comp'=>false],
        ];

        foreach ($mapArray as $key => $map) {
          Map::create($map); // don't use "insert", it does not set timestamps
        }
    }
}
