<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class FreshItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the items table from the seeder file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm("Do you wish to preserve current item prices?")) {
            $this->call('db:seed --class=ItemSeeder');
        } else {
            Item::query()->truncate();
            $this->call('db:seed --class=ItemSeeder');
        }
    }
}
