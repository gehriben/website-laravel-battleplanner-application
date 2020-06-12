<?php

use App\Models\User;
use App\Models\Map;
use App\Models\Floor;
use App\Models\Operator;
use App\Models\Gadget;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

use Illuminate\Database\Seeder;

/**
 * This seeder should not be used in production, it is simply a sample seeder to make testing the application simpler.
 * This seeder should not be included in the DatabaseSeeder.php
 * To execute:
 * php artisan db:seed --class=SampleSeeder
 */
class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->map();
        $this->operators();
        $this->gadget();
    }

    private function map(){
        $file = new UploadedFile(
            database_path('seeds/media/map/r6-maps-bank-blueprint-1.jpg'),
            'r6-maps-bank-blueprint-1.jpg',
            '.jpg',
            1234,
            null,
            TRUE
        );

        $map = factory(Map::class)->create([
            'name' => 'Bank',
            'thumbnail_id' => Media::fromFile($file, 'maps/Bank', 'public')->id,
        ]);

        $order = 0;
        foreach (File::files(database_path('seeds/media/map')) as $path)
        {
            $file = new UploadedFile(
                $path,
                $path,
                '.jpg',
                1234,
                null,
                TRUE
            );

            $floor1 = Floor::create([
                'name' => '1',
                'order' => $order++,
                'source_id' => Media::fromFile($file, 'maps/Bank', 'public')->id,
                'map_id' => $map->id
            ]);
        }
    }

    private function operators(){

        //Iana
        $file = new UploadedFile(
            database_path('seeds/media/operator/r6s-operator-badge-iana.png'),
            'r6s-operator-badge-iana.png',
            '.png',
            1234,
            null,
            TRUE
        );

        $operator = Operator::create([
            'name' => 'Iana',
            'colour' => '#ffffff',
            'attacker' => true,
            'icon_id' => Media::fromFile($file, 'operators/Iana', 'public')->id
        ]);

        // oryx
        $file = new UploadedFile(
            database_path('seeds/media/operator/r6s-operator-badge-oryx.png'),
            'r6s-operator-badge-oryx',
            '.png',
            1234,
            null,
            TRUE
        );

        $operator = Operator::create([
            'name' => 'Oryx',
            'colour' => '#000000',
            'attacker' => false,
            'icon_id' => Media::fromFile($file, 'operators/Oryx', 'public')->id
        ]);
    }

    private function gadget(){

        //Iana
        $file = new UploadedFile(
            database_path('seeds/media/gadget/flashbang.jpg'),
            'flashbang.png',
            '.jpg',
            1234,
            null,
            TRUE
        );

        $operator = Gadget::create([
            'name' => 'Flashbang',
            'icon_id' => Media::fromFile($file, 'gadgets/flashbang', 'public')->id
        ]);

    }
}
