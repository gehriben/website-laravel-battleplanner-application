<?php

use Illuminate\Database\Seeder;
use App\Models\Operator;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operatorArray = [
          /* DEFENDERS */
          /*Clash*/['name'=> "Clash", 'icon'=> "/media/ops/Clash.png", 'colour'=> "718190", 'atk'=> false],
          /*Maestro*/['name'=> "Maestro", 'icon'=> "/media/ops/Maestro.png", 'colour'=> "666e24", 'atk'=> false],
          /*Alibi*/['name'=> "Alibi", 'icon'=> "/media/ops/Alibi.png", 'colour'=> "666e24", 'atk'=> false],
          /*Vigil*/['name'=> "Vigil", 'icon'=> "/media/ops/Vigil.png", 'colour'=> "ffffff", 'atk'=> false],
          /*Ela*/['name'=> "Ela", 'icon'=> "/media/ops/Ela.png", 'colour'=> "539d9b", 'atk'=> false],
          /*Lesion*/['name'=> "Lesion", 'icon'=> "/media/ops/Lesion.png", 'colour'=> "a94825", 'atk'=> false],
          /*Mira*/['name'=> "Mira", 'icon'=> "/media/ops/Mira.png", 'colour'=> "521a7f", 'atk'=> false],
          /*Echo*/['name'=> "Echo", 'icon'=> "/media/ops/Echo.png", 'colour'=> "984153", 'atk'=> false],
          /*Caveira*/['name'=> "Caveira", 'icon'=> "/media/ops/Caveira.png", 'colour'=> "478b40", 'atk'=> false],
          /*Valkyrie*/['name'=> "Valkyrie", 'icon'=> "/media/ops/Valkyrie.png", 'colour'=> "c39100", 'atk'=> false],
          /*Frost*/['name'=> "Frost", 'icon'=> "/media/ops/Frost.png", 'colour'=> "00789d", 'atk'=> false],
          /*Mute*/['name'=> "Mute", 'icon'=> "/media/ops/Mute.png", 'colour'=> "906e79", 'atk'=> false],
          /*Smoke*/['name'=> "Smoke", 'icon'=> "/media/ops/Smoke.png", 'colour'=> "906e79", 'atk'=> false],
          /*Castle*/['name'=> "Castle", 'icon'=> "/media/ops/Castle.png", 'colour'=> "d65b2b", 'atk'=> false],
          /*Pulse*/['name'=> "Pulse", 'icon'=> "/media/ops/Pulse.png", 'colour'=> "d65b2b", 'atk'=> false],
          /*Doc*/['name'=> "Doc", 'icon'=> "/media/ops/Doc.png", 'colour'=> "3a6082", 'atk'=> false],
          /*Rook*/['name'=> "Rook", 'icon'=> "/media/ops/Rook.png", 'colour'=> "3a6082", 'atk'=> false],
          /*Jager*/['name'=> "Jager", 'icon'=> "/media/ops/Jager.png", 'colour'=> "f8c334", 'atk'=> false],
          /*Bandit*/['name'=> "Bandit", 'icon'=> "/media/ops/Bandit.png", 'colour'=> "f8c334", 'atk'=> false],
          /*Tachanka*/['name'=> "Tachanka", 'icon'=> "/media/ops/Tachanka.png", 'colour'=> "ab1513", 'atk'=> false],
          /*Kapkan*/['name'=> "Kapkan", 'icon'=> "/media/ops/Kapkan.png", 'colour'=> "ab1513", 'atk'=> false],

          /* ATTACKERS */
          /*Maverick*/['name'=> "Maverick", 'icon'=> "/media/ops/Maverick.png", 'colour'=> "718190", 'atk'=> true],
          /*Lion*/['name'=> "Lion", 'icon'=> "/media/ops/Lion.png", 'colour'=> "fcae1d", 'atk'=> true],
          /*Finka*/['name'=> "Finka", 'icon'=> "/media/ops/Finka.png", 'colour'=> "fcae1d", 'atk'=> true],
          /*Dokkaebi*/['name'=> "Dokkaebi", 'icon'=> "/media/ops/Dokkaebi.png", 'colour'=> "ffffff", 'atk'=> true],
          /*Zofia*/['name'=> "Zofia", 'icon'=> "/media/ops/Zofia.png", 'colour'=> "539d9b", 'atk'=> true],
          /*Ying*/['name'=> "Ying", 'icon'=> "/media/ops/Ying.png", 'colour'=> "a94825", 'atk'=> true],
          /*Jackal*/['name'=> "Jackal", 'icon'=> "/media/ops/Jackal.png", 'colour'=> "521a7f", 'atk'=> true],
          /*Hibana*/['name'=> "Hibana", 'icon'=> "/media/ops/Hibana.png", 'colour'=> "984153", 'atk'=> true],
          /*Capitao*/['name'=> "Capitao", 'icon'=> "/media/ops/Capitao.png", 'colour'=> "478b40", 'atk'=> true],
          /*Blackbeard*/['name'=> "Blackbeard", 'icon'=> "/media/ops/Blackbeard.png", 'colour'=> "c39100", 'atk'=> true],
          /*Buck*/['name'=> "Buck", 'icon'=> "/media/ops/Buck.png", 'colour'=> "00789d", 'atk'=> true],
          /*Sledge*/['name'=> "Sledge", 'icon'=> "/media/ops/Sledge.png", 'colour'=> "906e79", 'atk'=> true],
          /*Thatcher*/['name'=> "Thatcher", 'icon'=> "/media/ops/Thatcher.png", 'colour'=> "906e79", 'atk'=> true],
          /*Ash*/['name'=> "Ash", 'icon'=> "/media/ops/Ash.png", 'colour'=> "d65b2b", 'atk'=> true],
          /*Thermite*/['name'=> "Thermite", 'icon'=> "/media/ops/Thermite.png", 'colour'=> "d65b2b", 'atk'=> true],
          /*Montagne*/['name'=> "Montagne", 'icon'=> "/media/ops/Montagne.png", 'colour'=> "3a6082", 'atk'=> true],
          /*Twitch*/['name'=> "Twitch", 'icon'=> "/media/ops/Twitch.png", 'colour'=> "3a6082", 'atk'=> true],
          /*Blitz*/['name'=> "Blitz", 'icon'=> "/media/ops/Blitz.png", 'colour'=> "f8c334", 'atk'=> true],
          /*IQ*/['name'=> "IQ", 'icon'=> "/media/ops/Iq.png", 'colour'=> "f8c334", 'atk'=> true],
          /*Fuze*/['name'=> "Fuze", 'icon'=> "/media/ops/Fuze.png", 'colour'=> "ab1513", 'atk'=> true],
          /*Glaz*/['name'=> "Glaz", 'icon'=> "/media/ops/Glaz.png", 'colour'=> "ab1513", 'atk'=> true],
        ];
        Operator::insert($operatorArray);
    }
}
