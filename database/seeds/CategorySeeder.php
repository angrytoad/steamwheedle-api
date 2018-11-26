<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'Weapons',
            'Armor',
            'Container',
            'Consumable',
            'Reagents',
            'Miscellaneous',
            'Alchemy',
            'Blacksmithing',
            'Enchanting',
            'Engineering',
            'Herbalism',
            'Leatherworking',
            'Mining',
            'Skinning',
            'Tailoring'
        ];

        $this->process($list);
    }

    private function process(array $list)
    {
        foreach ($list as $name) {
            if (!$cat = Category::where('name', $name)->first()) {
                $new = new Category();
                $new->name = $name;
                $new->save();
            }
        }
    }
}
