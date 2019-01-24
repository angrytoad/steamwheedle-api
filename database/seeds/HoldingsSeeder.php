<?php

use Illuminate\Database\Seeder;
use App\Models\Holding;
use App\Models\Item;

class HoldingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $holdings = [
        'Topper McNabb' => [                     // Name of holding is the key
            'item' => null,                   // Use name run function will pull the correct ID
            'flavour' => 'Spare some change for a poor blind man?',
            'zone' => 'Any',
            'image' => '/img/holdings/topper_mcnabb.jpg',
            'required_level' => 0,
            'cost' => 33000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 0,
            'discount_upgrades_enabled' => 0,
            'xp_upgrades_enabled' => 0
        ],
        'Northshire Vineyards' => [
            'item' => 'Darnassian Bleu',
            'flavour' => 'This is our vineyard, scrub.',
            'zone' => 'Elwynn Forest',
            'image' => '/img/holdings/northshire_vineyards.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Grelin\'s Hunting Camp' => [
            'item' => 'Healing Herb',
            'flavour' => 'Well? Those frostmane arn\'t going to kill themselves are they?',
            'zone' => 'Dun Morogh',
            'image' => '/img/holdings/grelins_hunting_camp.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Maneweavers Lodge' => [
            'item' => 'Ruined Leather Scraps',
            'flavour' => 'Have you ever tried to skin and owl?',
            'zone' => 'Teldrassil',
            'image' => '/img/holdings/maneweavers_lodge.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Bael\'dun Digsite' => [
            'item' => 'Rough Stone',
            'flavour' => 'Watch yer back...',
            'zone' => 'Mulgore',
            'image' => '/img/holdings/baeldun_digsite.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Scuttle Coast Fishing Rights' => [
            'item' => 'Raw Slitherskin Mackerel',
            'flavour' => 'Don\'t go in the water barefoot!',
            'zone' => 'Durotar',
            'image' => '/img/holdings/scuttle_coast_fishing_rights.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Solliden\'s Farmstead' => [
            'item' => 'Moon Harvest Pumpkin',
            'flavour' => 'Gerr off my land!',
            'zone' => 'Tirisfal Glades',
            'image' => '/img/holdings/sollidens_farmstead.jpg',
            'required_level' => 5,
            'cost' => 75000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Eastvale Logging Camp' => [
            'item' => 'Linen Cloth',
            'flavour' => 'Wot is it? More work?',
            'zone' => 'Elwynn Forest',
            'image' => '/img/holdings/eastvale_logging_camp.jpg',
            'required_level' => 10,
            'cost' => 100000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Amberstill Ranch' => [
            'item' => 'Haunch of Meat',
            'flavour' => 'Its time to protect the herd.',
            'zone' => 'Dun Morogh',
            'image' => '/img/holdings/amberstill_ranch.jpg',
            'required_level' => 10,
            'cost' => 100000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
        'Starbreeze Village Moonwell' => [
            'item' => 'Refreshing Spring Water',
            'flavour' => 'Quench your thirst with the power of the moon!',
            'zone' => 'Teldrassil',
            'image' => '/img/holdings/starbreeze_village_moonwell.jpg',
            'required_level' => 10,
            'cost' => 100000,
            'rent_interval' => 8,
            'rent_upgrades_enabled' => 1,
            'discount_upgrades_enabled' => 1,
            'xp_upgrades_enabled' => 1
        ],
    ];

    public function run()
    {
        foreach ($this->holdings as $name => $holding) {
            if (!$existing = Holding::where('name', $name)->first()) {
                $existing = new Holding();
            }
            if (!$item = Item::where('name', $holding['item'])->first()) {
                $existing->item_id = null;
            }else{
                $existing->item_id = $item->id;
            }
            foreach ($holding as $key => $value) {
                $existing->$key = $value;
            }
            $existing->name = $name;
            $existing->save();
        }
    }
}
