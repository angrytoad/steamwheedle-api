<?php

use Illuminate\Database\Seeder;
use App\Models\Holding;

class HoldingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $holdings = [
        'Topper McNabb' => [                     // Name of holding is the key
            'item_id' => null,                   // Use name run function will pull the correct ID
            'flavour' => 'Spare some change for a poor blind man?',
            'zone' => 'Any',
            'image' => '/img/holdings/toppermcnabb.png',
            'required_level' => 0,
            'cost' => 33000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 0,
            'discount_upgrades_enabled' => 0,
            'xp_upgrades_enabled' => 0
        ],
        'Northshire Vineyards' => [
            'item_id' => '175aa7e0-fc9a-11e8-beba-f99f28a2dfa6',
            'flavour' => 'This is our vineyard, scrub.',
            'zone' => 'Elwynn Forest',
            'image' => '',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Grelin\'s Hunting Camp' => [
            'item_id' => '175aa7e0-fc9a-11e8-beba-f99f28a2dfa6',
            'flavour' => 'Well? Those frostmane arn\'t going to kill themselves are they?',
            'zone' => 'Dun Morogh',
            'image' => '/img/holdings/grelinshuntingcamp.png',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Maneweavers Lodge' => [
            'item_id' => '175aa7e0-fc9a-11e8-beba-f99f28a2dfa6',
            'flavour' => 'Have you ever tried to skin and owl?',
            'zone' => 'Teldrassil',
            'image' => '/img/holdings/maneweaverslodge.png',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Bael\'dun Digsite' => [
            'item_id' => '175aa7e0-fc9a-11e8-beba-f99f28a2dfa6',
            'flavour' => 'Watch yer back...',
            'zone' => 'Mulgore',
            'image' => '/img/holdings/baeldundigsite.png',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ]
    ];

    public function run()
    {
        foreach ($this->holdings as $name => $holding) {
            if (!$existing = Holding::where('name', $name)->first()) {
                $existing = new Holding();
            }
            foreach ($holding as $key => $value) {
                $existing->$key = $value;
            }
            $existing->name = $name;
            $existing->save();
        }
    }
}
