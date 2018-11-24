<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Risk;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Strange Dust' => [
                'description' => 'A mysterious dust used for low level enchanting.',
                'current_price' => 500,
                'risk_id' => 2,
                'image' => 'strangedust.png'
            ],
            'Peacebloom' => [
                'description' => 'A common herb used in minor healing potions.',
                'current_price' => 200,
                'risk_id' => 1,
                'image' => 'peacebloom.png'
            ],
            'Thick Leather' => [
                'description' => 'A thick animal skin used in crafting armor.',
                'current_price' => 2500,
                'risk_id' => 2,
                'image' => 'thickleather.png'
            ],
            'Arcane Crystals' => [
                'description' => 'A rare yellow crystal sometimes found in thorium veins, used in the transmutation of arcanite.',
                'current_price' => 10000,
                'risk_id' => 4,
                'image' => 'arcanecrystal.png'
            ],
            'Sulfuron Ingot' => [
                'description' => 'The pinnacle of all wrought metals, used in the crafting of the Sulfuron Hammer',
                'current_price' => 500000,
                'risk_id' => 3,
                'image' => 'sulfuroningot.png'
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
                $item->image = '/img/' . $props['image'];
                $item->save();
            } else {
                $item = new Item();
                $item->name = $name;
                $item->description = $props['description'];
                $item->risk_id = $props['risk_id'];
                $item->image = '/img/' . $props['image'];
                $item->current_price = $props['current_price'];
                $item->save();
            }
        }
    }
}
