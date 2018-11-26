<?php

use Illuminate\Database\Seeder;
use App\Models\ItemRarity;

class RaritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rarities = [
            [
                'rarity_id' => 1,
                'name' => 'Poor',
            ],
            [
                'rarity_id' => 2,
                'name' => 'Common',
            ],
            [
                'rarity_id' => 3,
                'name' => 'Uncommon',
            ],
            [
                'rarity_id' => 4,
                'name' => 'Rare',
            ],
            [
                'rarity_id' => 5,
                'name' => 'Epic',
            ],
            [
                'rarity_id' => 6,
                'name' => 'Legendary',
            ],
            [
                'rarity_id' => 7,
                'name' => 'Artifact',
            ],
            [
                'rarity_id' => 8,
                'name' => 'Heirloom',
            ],
        ];
        $this->process($rarities);
    }

    private function process(array $rarities)
    {
        foreach ($rarities as $props) {
            if (!$rarity = ItemRarity::where('rarity_id', $props['rarity_id'])->first()) {
                $rarity = new ItemRarity();
                $rarity->fill($props);
                $rarity->save();
            } else {
                $rarity->name = $props['name'];
                $rarity->save();
            }

        }
    }
}
