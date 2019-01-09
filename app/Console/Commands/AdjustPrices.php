<?php

namespace App\Console\Commands;

use App\Services\PriceAdjustmentService;
use Illuminate\Console\Command;
use App\Services\MetricService;

class AdjustPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adjust:prices {times=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs the 5min interval price changes on all items and updates metrics.';

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
     * @param PriceAdjustmentService $adjuster
     * @param MetricService $metrics
     * @return void
     */
    public function handle(PriceAdjustmentService $adjuster, MetricService $metrics)
    {
        $metric = $metrics->doMetrics();
        $times = $this->argument('times');
        $count = 0;
        do {
            $adjuster->adjust();
            $count++;
        } while($count != $times);
        $metrics->recordEnd($metric);
    }
}
