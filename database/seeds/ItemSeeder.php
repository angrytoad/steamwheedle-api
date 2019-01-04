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
        $list = config('items');
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
