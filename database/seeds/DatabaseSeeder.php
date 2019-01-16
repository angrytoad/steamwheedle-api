<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CategorySeeder');
        $this->call('RiskSeeder');
        $this->call('RaritySeeder');
        $this->call('ItemSeeder');
        $this->call('HoldingSeeder');
    }
}
