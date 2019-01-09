<?php namespace App\Services;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/19
 * Time: 14:20
 */

use App\Models\Metric;
use App\Models\User;
use App\Models\ItemPurchase;
use App\Models\HistoricTransaction;
use Illuminate\Support\Carbon;

class MetricService
{

    public function __construct()
    {

    }

    /**
     * Record a metric record regarding the past time interval
     *
     * @return Metric
     */
    public function doMetrics() :Metric
    {
        $metric = new Metric();
        $metric->players = count(User::all());
        $metric->wealth = $this->gatherWealth();
        $metric->salesInPeriod = $this->getSales();
        $metric->purchasesInPeriod = $this->getPurchases();
        $metric->save();

        return $metric;
    }


    /**
     * Record the end of the update in the previously created metric
     *
     * @param Metric $metric
     */
    public function recordEnd(Metric $metric) :void
    {
        $metric->save();
    }

    /**
     * Calculate the total wealth of the gamestate
     *
     * @return int
     */
    private function gatherWealth() :int
    {
        $wealth = 0;
        foreach(User::all() as $user) {
            $wealth += $user->balance;
        }
        foreach(ItemPurchase::all() as $stock) {
            $wealth += $stock->current * $stock->item()->current_price;
        }
        return $wealth;
    }

    /**
     * Get sales for the last update period
     *
     * @return int
     */
    private function getSales() :int
    {
        return HistoricTransaction::where('type', 0)->where('updated_at', '>=', Carbon::createFromTimestamp(now()->timestamp - config('adjustment.interval')))->sum('quantity');

    }

    /**
     * Get Purchases for the last update period
     *
     * @return int
     */
    private function getPurchases() :int
    {
        return HistoricTransaction::where('type', 1)->where('updated_at', '>=', Carbon::createFromTimestamp(now()->timestamp - config('adjustment.interval')))->sum('quantity');
    }
}