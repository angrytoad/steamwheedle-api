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
     * @return float
     */
    private function calcProportionChange(Item $item) :float
    {
        // Get the difference in buy and sells for a specified item
        $diff = HistoricTransaction::difference($item, $this->interval);

        // If sales are equal to purchases make no price change
        if ($diff === 0) {
            // Check if price RNG is turned on in the env file
            if (env('APP_RNG', false) == false) {
                return 0;
            }
            // Gen a random number 80% no movement, 10% up, 10% down
            $rng = rand(1, 10);
            if ($rng <= 8) {
                return 0;
            } elseif($rng > 9) {
                $diff = 1;
            } else {
                $diff = -1;
            }
        }
        if ($diff > 0) {

            /*
             * Proportion is essentially current price divided by max price, normalised by reducing both by the base price for a scale that starts at 0
             */

            $max = $item->base_price * $this->upperBound;
            $proportion = 1 - ($item->current_price - $item->base_price) / ($max - $item->base_price);
        } elseif ($diff < 0) {

            /*
             * Proportion is the inverse of the rate between minimum and the current using the base price as a maximum
             */

            /**
             * I Can't seem to get this working, going up in price seems to be working fine but I can't seem to go down in price
             * past the base price this is because in the case of strange dust, the min is 200 (500 base) which means the proportion calculation
             * seems to even itself out if you do the maths.
             */
            $min = $item->base_price * $this->lowerBound;
            $proportion = -($item->current_price - $min) / ($item->base_price - $min);
        } else {
            // If the item is at its base price then the full swing is used
            $proportion = 1;
        }
        // Apply the specified rounding
        return ($item->risk->swing * $proportion) / 100;
    }

    public function adjust($cycles = 1)
    {
        // Cycle through each item and calculate the adjustment
        for($i = 0; $i < $cycles; $i++){
            foreach ($this->items as $item)
            {
                $change = $this->calcProportionChange($item);
                if ($change !== 0) {
                    $increase = $item->current_price * $change;
                    // To compensate for rounding on negative numbers, trying to avoid 0 here
                    if ($increase > 0) {
                        $increase = ceil($increase);
                    } elseif ($increase < 0) {
                        $increase = floor($increase);
                    }
                    $item->current_price = $this->round($item->current_price + $increase);
                    $item->save();
                }
            }
        }

    }

    private function round($float)
    {
        if($float < 0){
            return floor($float);
        }elseif ($float > 0){
            return ceil($float);
        }
        return $float;

        /**
         * I've changed rounding for now and left this in incase we ever want to change it back. Because the float can be
         * less than 0, rounding gets a bit weird and in some cases, won't allow a full reduction of price down to the minimum
         * value.
         */
        /*
            if ($this->rounding === -1) {
                return floor($float);
            } elseif ($this->rounding === 0) {
                return round($float);
            } elseif ($this->rounding === 1) {
                return ceil($float);
            }
            return floor($float);
        */
    }

}