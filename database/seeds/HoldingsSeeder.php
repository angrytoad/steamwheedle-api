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
        '' => [                     // Name of holding is the key
            'item_id' => '',        // Use name run function will pull the correct ID
            'flavour' => '',
            'zone' => '',
            'image' => '',
            'required_level' => 0,
            'cost' => 0,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ]
    ];

    public function run()
    {
        foreach (Holding::all() as $holdingRecord) {

        }
    }
}
