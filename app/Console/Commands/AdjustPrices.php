<?php

namespace App\Console\Commands;

use App\Services\PriceAdjustmentService;
use Illuminate\Console\Command;

class AdjustPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adjust:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs the 5min interval price changes on all items.';

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
    public function handle(PriceAdjustmentService $adjuster)
    {
        $adjuster->adjust();
    }
}
