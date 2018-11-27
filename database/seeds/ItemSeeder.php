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
            ]
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
                $item->save();
            }
        }
    }
}
