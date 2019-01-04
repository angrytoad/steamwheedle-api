<?php

namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class ResetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:prices {--current} {--base}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets all item prices to the base price defined in the items config file, preserving the ids.';

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
        $config = config('items');
        $items = Item::all();
        foreach ($items as $item) {
            if (key_exists($item->name, $config)) {
                if (!$this->option('current') && $this->option('base')) {
                    $item->base_price = $config[$item->name]['current_price'];
                    $item->current_price = $config[$item->name]['current_price'];
                }
                if ($this->option('base')) {
                    $item->base_price = $config[$item->name]['current_price'];
                }
                if ($this->option('current')) {
                    $item->current_price = $config[$item->name]['current_price'];
                }
                $item->save();
            }
        }
    }
}
