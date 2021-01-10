<?php

use Illuminate\Database\Seeder;

use App\Models\Map;
use App\Models\Floor;
use App\Models\Battleplan;
use App\Models\Battlefloor;

class ConvertAthenaToUbisoftSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $athenaMaps = Map::where('name','like', '%Athena%')->get();
        // dd($athenaMaps);

        foreach ($athenaMaps as $key => $athenaMap) {
            // Get ubisoft version
            $nameSplit = explode(" ",$athenaMap->name);
            $ubisoftMap = Map::where('name','like', "%$nameSplit[0]%Ubisoft%")->first();

            // Ubisoft version not found
            if(!$ubisoftMap){
                echo "\nCannot auto-convert $athenaMap->name. Ubisoft Version not found\n";
                continue;
            }

            echo "\nAuto-converting $athenaMap->name to $ubisoftMap->name\n";

            // Floor missmatch (Ubisoft has more than athena)
            if(count($athenaMap->floors) < count($ubisoftMap->floors)){
                $battleplans = Battleplan::where('map_id',$athenaMap->id)->get();

                /**
                 * Get the difference
                 */
                $count = count($ubisoftMap->floors) - count($athenaMap->floors);
                $difference = array_slice($ubisoftMap->floors->pluck("id")->toArray(), $count);

                /**
                 * For every battleplan missing an a floor for the conversion, create the floor manually
                 */
                foreach($battleplans as $key => $battleplan){
                    foreach ($difference as $key => $floorId) {
                        Battlefloor::create([
                            "floor_id" => $floorId,
                            "battleplan_id" => $battleplan->id,
                        ]);
                    }
                }

            }

            // update any battleplan using athena map_id to ubisoft id
            DB::update('update battleplans set map_id = ? where map_id = ?', [ $ubisoftMap->id, $athenaMap->id]);

            // Update the floors
            foreach ($athenaMap->floors()->orderBy('order')->get() as $key => $athenaFloor) {

                // Get ubisoft equivalent
                $ubisoftFloors = $ubisoftMap->floors()->orderBy('order')->get();

                /**
                 * Athena has more than ubisoft, delete the extra's
                 */
                if(!isset($ubisoftFloors[$key])){
                    DB::table('battlefloors')->where('floor_id', $athenaFloor->id)->delete();
                }

                else{
                    // update any battleplan using athena map_id to ubisoft id
                    $ubisoftFloor = $ubisoftFloors[$key];
                    DB::update('update battlefloors set floor_id = ? where floor_id = ?', [ $ubisoftFloor->id, $athenaFloor->id]);
                }


            }
        }
    }
}
