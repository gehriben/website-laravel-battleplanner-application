<?php

use Illuminate\Database\Seeder;
use App\Models\Gadget;

class GadgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $gadgetArray = [
        /*Clash*/['name'=> "Clash", 'icon'=> "/media/tools/unique/Clash.png", 'prime'=> true, 'general'=> false],
        /*Maverick*/['name'=> "Maverick", 'icon'=> "/media/tools/unique/Maverick.png", 'prime'=> true, 'general'=> false],
        /*Maestro*/['name'=> "Maestro", 'icon'=> "/media/tools/unique/Maestro.png", 'prime'=> true, 'general'=> false],
        /*Alibi*/['name'=> "Alibi", 'icon'=> "/media/tools/unique/Alibi.png", 'prime'=> true, 'general'=> false],
        /*Lion*/['name'=> "Lion", 'icon'=> "/media/tools/unique/Lion.png", 'prime'=> true, 'general'=> false],
        /*Finka*/['name'=> "Finka", 'icon'=> "/media/tools/unique/Finka.png", 'prime'=> true, 'general'=> false],
        /*Vigil*/['name'=> "Vigil", 'icon'=> "/media/tools/unique/Vigil.png", 'prime'=> true, 'general'=> false],
        /*Dokkaebi*/['name'=> "Dokkaebi", 'icon'=> "/media/tools/unique/Dokkaebi.png", 'prime'=> true, 'general'=> false],
        /*Zofia*/['name'=> "Zofia", 'icon'=> "/media/tools/unique/Zofia.png", 'prime'=> true, 'general'=> false],
        /*Ela*/['name'=> "Ela", 'icon'=> "/media/tools/unique/Ela.png", 'prime'=> true, 'general'=> false],
        /*Ying*/['name'=> "Ying", 'icon'=> "/media/tools/unique/Ying.png", 'prime'=> true, 'general'=> false],
        /*Lesion*/['name'=> "Lesion", 'icon'=> "/media/tools/unique/Lesion.png", 'prime'=> true, 'general'=> false],
        /*Mira*/['name'=> "Mira", 'icon'=> "/media/tools/unique/Mira.png", 'prime'=> true, 'general'=> false],
        /*Jackal*/['name'=> "Jackal", 'icon'=> "/media/tools/unique/Jackal.png", 'prime'=> true, 'general'=> false],
        /*Hibana*/['name'=> "Hibana", 'icon'=> "/media/tools/unique/Hibana.png", 'prime'=> true, 'general'=> false],
        /*Echo*/['name'=> "Echo", 'icon'=> "/media/tools/unique/Echo.png", 'prime'=> true, 'general'=> false],
        /*Caveira*/['name'=> "Caveira", 'icon'=> "/media/tools/unique/Caveira.png", 'prime'=> true, 'general'=> false],
        /*Capitao*/['name'=> "Capitao", 'icon'=> "/media/tools/unique/Capitao.png", 'prime'=> true, 'general'=> false],
        /*Blackbeard*/['name'=> "Blackbeard", 'icon'=> "/media/tools/unique/Blackbeard.png", 'prime'=> true, 'general'=> false],
        /*Valkyrie*/['name'=> "Valkyrie", 'icon'=> "/media/tools/unique/Valkyrie.png", 'prime'=> true, 'general'=> false],
        /*Buck*/['name'=> "Buck", 'icon'=> "/media/tools/unique/Buck.png", 'prime'=> true, 'general'=> false],
        /*Frost*/['name'=> "Frost", 'icon'=> "/media/tools/unique/Frost.png", 'prime'=> true, 'general'=> false],
        /*Mute*/['name'=> "Mute", 'icon'=> "/media/tools/unique/Mute.png", 'prime'=> true, 'general'=> false],
        /*Sledge*/['name'=> "Sledge", 'icon'=> "/media/tools/unique/Sledge.png", 'prime'=> true, 'general'=> false],
        /*Smoke*/['name'=> "Smoke", 'icon'=> "/media/tools/unique/Smoke.png", 'prime'=> true, 'general'=> false],
        /*Thatcher*/['name'=> "Thatcher", 'icon'=> "/media/tools/unique/Thatcher.png", 'prime'=> true, 'general'=> false],
        /*Ash*/['name'=> "Ash", 'icon'=> "/media/tools/unique/Ash.png", 'prime'=> true, 'general'=> false],
        /*Castle*/['name'=> "Castle", 'icon'=> "/media/tools/unique/Castle.png", 'prime'=> true, 'general'=> false],
        /*Pulse*/['name'=> "Pulse", 'icon'=> "/media/tools/unique/Pulse.png", 'prime'=> true, 'general'=> false],
        /*Thermite*/['name'=> "Thermite", 'icon'=> "/media/tools/unique/Thermite.png", 'prime'=> true, 'general'=> false],
        /*Montagne*/['name'=> "Montagne", 'icon'=> "/media/tools/unique/Montagne.png", 'prime'=> true, 'general'=> false],
        /*Twitch*/['name'=> "Twitch", 'icon'=> "/media/tools/unique/Twitch.png", 'prime'=> true, 'general'=> false],
        /*Doc*/['name'=> "Doc", 'icon'=> "/media/tools/unique/Doc.png", 'prime'=> true, 'general'=> false],
        /*Rook*/['name'=> "Rook", 'icon'=> "/media/tools/unique/Rook.png", 'prime'=> true, 'general'=> false],
        /*Jager*/['name'=> "Jager", 'icon'=> "/media/tools/unique/Jager.png", 'prime'=> true, 'general'=> false],
        /*Bandit*/['name'=> "Bandit", 'icon'=> "/media/tools/unique/Bandit.png", 'prime'=> true, 'general'=> false],
        /*Blitz*/['name'=> "Blitz", 'icon'=> "/media/tools/unique/Blitz.png", 'prime'=> true, 'general'=> false],
        /*IQ*/['name'=> "IQ", 'icon'=> "/media/tools/unique/IQ.png", 'prime'=> true, 'general'=> false],
        /*Fuze*/['name'=> "Fuze", 'icon'=> "/media/tools/unique/Fuze.png", 'prime'=> true, 'general'=> false],
        /*Glaz*/['name'=> "Glaz", 'icon'=> "/media/tools/unique/Glaz.png", 'prime'=> true, 'general'=> false],
        /*Tachanka*/['name'=> "Tachanka", 'icon'=> "/media/tools/unique/Tachanka.png", 'prime'=> true, 'general'=> false],
        /*Kapkan*/['name'=> "Kapkan", 'icon'=> "/media/tools/unique/Kapkan.png", 'prime'=> true, 'general'=> false],

        /*Secondary: Barbed Wire*/['name'=> "Barbed Wire", 'icon'=> "/media/tools/secondary/BarbedWire.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Breaching Charge*/['name'=> "Breaching Charge", 'icon'=> "/media/tools/secondary/BreachCharge.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Bulletproof Cam*/['name'=> "Bulletproof Cam", 'icon'=> "/media/tools/secondary/BulletCam.png", 'prime'=> false, 'general'=> false],
        /*Secondary: C4*/['name'=> "C4", 'icon'=> "/media/tools/secondary/C4.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Claymore*/['name'=> "Claymore", 'icon'=> "/media/tools/secondary/Claymore.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Deployable Shield*/['name'=> "Deployable Shield", 'icon'=> "/media/tools/secondary/DeployableShield.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Frag*/['name'=> "Frag", 'icon'=> "/media/tools/secondary/Frag.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Impact*/['name'=> "Impact", 'icon'=> "/media/tools/secondary/Impact.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Smoke*/['name'=> "Smoke", 'icon'=> "/media/tools/secondary/Smoke.png", 'prime'=> false, 'general'=> false],
        /*Secondary: Stun*/['name'=> "Stun", 'icon'=> "/media/tools/secondary/Stun.png", 'prime'=> false, 'general'=> false],

        /*General: 1*/['name'=> "1", 'icon'=> "/media/tools/general/1.png", 'prime'=> false, 'general'=> true],
        /*General: 2*/['name'=> "2", 'icon'=> "/media/tools/general/2.png", 'prime'=> false, 'general'=> true],
        /*General: 3*/['name'=> "3", 'icon'=> "/media/tools/general/3.png", 'prime'=> false, 'general'=> true],
        /*General: Barricade*/['name'=> "Barricade", 'icon'=> "/media/tools/general/Barricade.png", 'prime'=> false, 'general'=> true],
        /*General: Drone*/['name'=> "Drone", 'icon'=> "/media/tools/general/Drone.png", 'prime'=> false, 'general'=> true],
        /*General: Obj*/['name'=> "Obj", 'icon'=> "/media/tools/general/Obj.png", 'prime'=> false, 'general'=> true],
        /*General: Rappel*/['name'=> "Rappel", 'icon'=> "/media/tools/general/Rappel.png", 'prime'=> false, 'general'=> true],
        /*General: Reinforcement*/['name'=> "Reinforcement", 'icon'=> "/media/tools/general/Reinforcement.png", 'prime'=> false, 'general'=> true],
      ];

      foreach ($gadgetArray as $key => $gadget) {
        Gadget::create($gadget); // don't use "insert", it does not set timestamps
      }
      
    }
}
