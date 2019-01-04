<?php namespace App\Services;

use App\Models\Item;
use App\Models\HistoricTransaction;

class PriceAdjustmentService {

    //config options
    protected $rounding;
    protected $interval;
    protected $upperBound;
    protected $lowerBound;

    public function __construct(array $config)
    {
        $this->configure($config);
        $this->items = Item::all();
    }

    private function configure(array $config) :void
    {
        $this->rounding = $config['rounding'];
        $this->interval = $config['interval'];
        $this->upperBound = $config['upperBound'];
        $this->lowerBound = $config['lowerBound'];
    }

    /**
     * Calculates the percentage change for each item provided, this is proportional to the relative current price to the base price
     *
     * @param Item $item
     * @return int
     */
    private function calcProportionChange(Item $item) :int
    {
        // Get the difference in buy and sells for a specified item
        $diff = HistoricTransaction::difference($item, $this->interval);
        // If sales are equal to purchases make no price change
        if ($diff === 0) {
            return 0;
        }
        if ($item->current_price > $item->base_price) {

            /*
             * Proportion is essentially current price divided by max price, normalised by reducing both by the base price for a scale that starts at 0
             */

            $max = $item->base_price * $this->upperBound;
            $proportion = ($item->current_price - $item->base_price) / ($max - $item->base_price);

        } elseif ($item->current_price < $item->base_price) {

            /*
             * Proportion is the inverse of the rate between minimum and the current using the base price as a maximum
             */

            $min = $item->base_price * $this->lowerBound;
            $proportion = 1 - ($item->current_price - $min) / ($item->base_price - $min);

        } else {
            // If the item is at its base price then the full swing is used
            $proportion = 1;
        }
        // Apply the specified rounding
        return ($item->risk->swing * $proportion) / 100;
    }

    public function adjust()
    {
        // Cycle through each item and calculate the adjustment
        foreach ($this->items as $item)
        {
            $change = $this->calcProportionChange($item);
            if ($change !== 0) {
                $item->current_price = $this->round($item->current_price * $change);
                $item->save();
            }
        }
    }

    private function round($float)
    {
        if ($this->rounding === -1) {
            return floor($float);
        } elseif ($this->rounding === 0) {
            return round($float);
        } elseif ($this->rounding === 1) {
            return ceil($float);
        }
        return floor($float);
    }

}