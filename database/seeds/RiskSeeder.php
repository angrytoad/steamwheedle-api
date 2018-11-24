<?php

use Illuminate\Database\Seeder;
use App\Models\Risk;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Risk::query()->truncate();
        $risks = [
            [
                'risk_id' => 1,
                'name' => 'Very Low',
                'swing' => 0.1
            ],
            [
                'risk_id' => 2,
                'name' => 'Low',
                'swing' => 0.5
            ],
            [
                'risk_id' => 3,
                'name' => 'Medium',
                'swing' => 1.5
            ],
            [
                'risk_id' => 4,
                'name' => 'High',
                'swing' => 5
            ],
            [
                'risk_id' => 5,
                'name' => 'Very High',
                'swing' => 10
            ]
        ];
        $this->process($risks);
    }

    private function process(array $risks)
    {
        foreach ($risks as $props) {
            $risk = new Risk();
            $risk->fill($props);
            $risk->save();
        }
    }
}
