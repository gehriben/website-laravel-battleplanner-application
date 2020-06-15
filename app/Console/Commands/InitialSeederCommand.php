<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

// Models
use App\Models\Map;
use App\Models\Floor;
use App\Models\Operator;
use App\Models\Gadget;
use App\Models\Media;

class InitialSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initial:all {path : path to the root assets}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the Database with Maps, Operators and Gadgets.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rootPath = $this->argument('path');
        
        $mapsPath =  $rootPath . '/maps';
        $operatorsPath =  $rootPath . '/operators';
        $gadgetsPath =  $rootPath . '/gadgets';

        $this->parseMaps($mapsPath);
        $this->parseOperators($operatorsPath);
        $this->parseGadgets($gadgetsPath);
    }

    private function parseMaps($mapsPath){

        $maps = array_diff(scandir($mapsPath), array('..', '.'));

        foreach ($maps as $key => $map) {
            $mapPath = $mapsPath . '/' . $map;

            $raw = file_get_contents($mapPath .'/meta.json');
            $mapJson =  json_decode($raw);
            
            $thumbnail = new UploadedFile(
                $mapsPath . "/${map}/" . $mapJson->thumbnail,
                $mapJson->thumbnail,
                $this->parseExtention($mapJson->thumbnail),
                1234,
                null,
                TRUE
            );

            $mapModel = Map::create([
                'name' => $mapJson->name,
                'competitive' => $mapJson->competitive,
                'thumbnail' => $thumbnail,
            ]);

            foreach ($mapJson->floors as $key => $floor)
            {
                $source = new UploadedFile(
                    $mapsPath . "/${map}/" . $floor,
                    $floor,
                    $this->parseExtention($floor),
                    1234,
                    null,
                    TRUE
                );

                $floor = Floor::create([
                    'name' => $floor,
                    'order' => $key,
                    'source_id' => Media::fromFile($source, "maps/${map}", 'public')->id,
                    'map_id' => $mapModel->id
                ]);
            }
        }
    }

    private function parseOperators($operatorsPath){

        $raw = file_get_contents($operatorsPath .'/meta.json');
        $operatorsJson =  json_decode($raw);


        foreach ($operatorsJson as $key => $operator) {
            
            $source = new UploadedFile(
                "{$operatorsPath}/{$operator->icon}",
                $operator->icon,
                $this->parseExtention($operator->icon),
                1234,
                null,
                TRUE
            );

            $operatorModel = Operator::create([
                'name' => $operator->name,
                'colour' => $operator->colour,
                'attacker' => $operator->attacker,
                'icon_id' => Media::fromFile($source, "operators/{$operator->name}", 'public')->id,
            ]);
        }
    }

    private function parseGadgets($gadgetsPath){

        $gadgets = array_diff(scandir($gadgetsPath), array('..', '.'));

        $raw = file_get_contents($gadgetsPath .'/meta.json');
        $gadgetsJson =  json_decode($raw);

        foreach ($gadgetsJson as $key => $gadget) {
            
            $source = new UploadedFile(
                "{$gadgetsPath}/{$gadget->icon}",
                $gadget->name,
                $this->parseExtention($gadget->icon),
                1234,
                null,
                TRUE
            );

            $operatorModel = Gadget::create([
                'name' => $gadget->name,
                'icon_id' => Media::fromFile($source, "gadgets/{$gadget->name}", 'public')->id,
            ]);
        }
    }

    private function parseExtention($path){
        $exploded = explode(".",$path);
        return $exploded[ count($exploded) - 1];
    }

    private function fileName($path){
        $exploded = explode(".",$path);
        return $exploded[0];
    }
}
