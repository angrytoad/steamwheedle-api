<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Risk;
use App\Models\Category;
use App\Models\ItemRarity;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Item Rarities
         * 1 - Poor
         * 2 - Common
         * 3 - Uncommon
         * 4 - Rare
         * 5 - Epic
         * 6 - Legendary
         * 7 - Artifact
         * 8 - Heirloom
         */

        $list = [
            'Strange Dust' => [
                'description' => 'A mysterious dust used for low level enchanting.',
                'current_price' => 500,
                'risk_id' => 2,
                'image' => 'strangedust.jpg',
                'category_id' => 'Enchanting',
                'rarity_id' => 2,
            ],
            'Peacebloom' => [
                'description' => 'A common herb used in minor healing potions.',
                'current_price' => 200,
                'risk_id' => 1,
                'image' => 'peacebloom.jpg',
                'category_id' => 'Herbalism',
                'rarity_id' => 2,
            ],
            'Thick Leather' => [
                'description' => 'A thick animal skin used in crafting armor.',
                'current_price' => 2500,
                'risk_id' => 4,
                'image' => 'thickleather.jpg',
                'category_id' => 'Skinning',
                'rarity_id' => 2,
            ],
            'Arcane Crystals' => [
                'description' => 'A rare yellow crystal sometimes found in thorium veins, used in the transmutation of arcanite.',
                'current_price' => 10000,
                'risk_id' => 4,
                'image' => 'arcanecrystal.jpg',
                'category_id' => 'Reagents',
                'rarity_id' => 3,
            ],
            'Sulfuron Ingot' => [
                'description' => 'The pinnacle of all wrought metals, used in the crafting of the Sulfuron Hammer',
                'current_price' => 500000,
                'risk_id' => 3,
                'image' => 'sulfuroningot.jpg',
                'category_id' => 'Blacksmithing',
                'rarity_id' => 5,
            ],

            // Containers
            'Kodo Hide Bag' => [
                'description' => 'This has definitely not been washed.',
                'current_price' => 1000,
                'risk_id' => 2,
                'image' => 'kodo_hide_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Linen Bag' => [
                'description' => 'A simple but effective way to store your items.',
                'current_price' => 800,
                'risk_id' => 1,
                'image' => 'linen_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Red Linen Bag' => [
                'description' => 'A simple but effective way to store your items. Now in Red!',
                'current_price' => 1000,
                'risk_id' => 2,
                'image' => 'red_linen_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Red Woolen Bag' => [
                'description' => 'Slightly bigger than a linen bag, and now 50% softer. Now in Red!',
                'current_price' => 2800,
                'risk_id' => 2,
                'image' => 'red_woolen_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Green Woolen Bag' => [
                'description' => 'Slightly bigger than a linen bag, and now 50% softer. Now in Green!',
                'current_price' => 1800,
                'risk_id' => 2,
                'image' => 'green_woolen_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Woolen Bag' => [
                'description' => 'Slightly bigger than a linen bag, and now 50% softer.',
                'current_price' => 1200,
                'risk_id' => 1,
                'image' => 'woolen_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Small Silk Pack' => [
                'description' => 'Fashionable and with plenty of room.',
                'current_price' => 8000,
                'risk_id' => 3,
                'image' => 'small_silk_pack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Green Silk Pack' => [
                'description' => 'Fashionable and with plenty of room. Now in Green!',
                'current_price' => 12000,
                'risk_id' => 2,
                'image' => 'green_silk_pack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Black Silk Pack' => [
                'description' => 'Fashionable and with plenty of room. Now in Black!',
                'current_price' => 16000,
                'risk_id' => 4,
                'image' => 'black_silk_pack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Large Knapsack' => [
                'description' => 'Large enough to fit a mount!',
                'current_price' => 20000,
                'risk_id' => 5,
                'image' => 'large_knapsack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Mageweave Bag' => [
                'description' => 'Woven from fine fabrics.',
                'current_price' => 10000,
                'risk_id' => 1,
                'image' => 'mageweave_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Red Mageweave Bag' => [
                'description' => 'Woven from fine fabrics. Now in Red!',
                'current_price' => 10000,
                'risk_id' => 3,
                'image' => 'red_mageweave_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Runecloth Bag' => [
                'description' => 'A staple for any budding adventurer.',
                'current_price' => 20000,
                'risk_id' => 1,
                'image' => 'runecloth_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Bottomless Bag' => [
                'description' => 'Its described at "Bottomless" but I can only fit about 18 different items in here...',
                'current_price' => 160000,
                'risk_id' => 3,
                'image' => 'bottomless_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 4,
            ],
            'Enchanted Mageweave Bag' => [
                'description' => 'Used by enchanters for storing all manner of Enchanting materials.',
                'current_price' => 10000,
                'risk_id' => 4,
                'image' => 'enchanted_mageweave_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Enchanted Runecloth Bag' => [
                'description' => 'Used by enchanters. A bigger bag for more materials.',
                'current_price' => 40000,
                'risk_id' => 2,
                'image' => 'enchanted_runecloth_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Big Bag of Enchantment' => [
                'description' => 'Used by enchanters. A huge bag for storing all you could need.',
                'current_price' => 120000,
                'risk_id' => 2,
                'image' => 'big_bag_of_enchantment.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Herb Pouch' => [
                'description' => 'A simple pouch for storing herbs.',
                'current_price' => 1000,
                'risk_id' => 1,
                'image' => 'herb_pouch.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Cenarion Herb Bag' => [
                'description' => 'Smells very fragrant when full.',
                'current_price' => 40000,
                'risk_id' => 4,
                'image' => 'cenarion_herb_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Satchel of Cenarius' => [
                'description' => 'Who needs this many herbs?',
                'current_price' => 120000,
                'risk_id' => 2,
                'image' => 'satchel_of_cenarius.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Soul Pouch' => [
                'description' => 'Used by warlocks for storing the souls of their victims. How exciting!',
                'current_price' => 20000,
                'risk_id' => 1,
                'image' => 'soul_pouch.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Felcloth Bag' => [
                'description' => 'The more souls the merrier.',
                'current_price' => 80000,
                'risk_id' => 3,
                'image' => 'felcloth_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 4,
            ],
            'Core Felcloth Bag' => [
                'description' => 'With great power comes great responsibility.',
                'current_price' => 320000,
                'risk_id' => 5,
                'image' => 'core_felcloth_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 5,
            ],
            'Traveler\'s Backpack' => [
                'description' => 'I\'m a rambling man.',
                'current_price' => 35000,
                'risk_id' => 2,
                'image' => 'travelers_backpack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Journeyman\'s Backpack' => [
                'description' => 'Its about the Journey, not the destination.',
                'current_price' => 25000,
                'risk_id' => 1,
                'image' => 'journeymans_backpack.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Troll-hide Bag' => [
                'description' => 'Its best not to think about what its made of.',
                'current_price' => 25000,
                'risk_id' => 4,
                'image' => 'troll_hide_bag.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Light Leather Quiver' => [
                'description' => 'For the everyday Robin Hood.',
                'current_price' => 100,
                'risk_id' => 1,
                'image' => 'light_leather_quiver.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Quickdraw Quiver' => [
                'description' => 'Rigid with plenty of space for arrows.',
                'current_price' => 4000,
                'risk_id' => 3,
                'image' => 'quickdraw_quiver.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Heavy Quiver' => [
                'description' => 'Double-studded leather makes this sturdy but heavy to carry.',
                'current_price' => 2000,
                'risk_id' => 2,
                'image' => 'heavy_quiver.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Small leather ammo pouch' => [
                'description' => 'Made to store small amounts of ammo.',
                'current_price' => 100,
                'risk_id' => 3,
                'image' => 'small_leather_ammo_pouch.jpg',
                'category_id' => 'Container',
                'rarity_id' => 2,
            ],
            'Thick leather ammo pouch' => [
                'description' => 'Ballistic amounts of space for your ammo!',
                'current_price' => 4000,
                'risk_id' => 2,
                'image' => 'thick_leather_ammo_pouch.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
            'Heavy leather ammo pouch' => [
                'description' => 'Ample space for all your ammo.',
                'current_price' => 2000,
                'risk_id' => 1,
                'image' => 'heavy_leather_ammo_pouch.jpg',
                'category_id' => 'Container',
                'rarity_id' => 3,
            ],
        ];

        $this->process($list);
    }

    private function process(array $list)
    {
        foreach ($list as $name => $props) {
            if ($item = Item::where('name', $name)->first()) {
                $item->description = $props['description'];
                $item->risk_id = Risk::where('risk_id', $props['risk_id'])->first()->id;
                $item->rarity_id = ItemRarity::where('rarity_id', $props['rarity_id'])->first()->id;
                $item->category_id = \App\Models\Category::where('name', $props['category_id'])->first()->id;
                $item->image = '/items/' . $props['image'];
                $item->base_price = $props['current_price'];
                $item->save();
            } else {
                $item = new Item();
                $item->name = $name;
                $item->description = $props['description'];
                $item->risk_id = Risk::where('risk_id', $props['risk_id'])->first()->id;
                $item->rarity_id = ItemRarity::where('rarity_id', $props['rarity_id'])->first()->id;
                $item->category_id = \App\Models\Category::where('name', $props['category_id'])->first()->id;
                $item->image = '/items/' . $props['image'];
                $item->current_price = $props['current_price'];
                $item->base_price = $props['current_price'];
                $item->save();
            }
        }
    }
}
