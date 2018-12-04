<?php namespace App\Services;

use App\Models\Item;
use App\Models\HistoricTransaction;

class PriceAdjustmentService {

    protected $items;
    protected $change = [];

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

    private function calcPercentChange(Item $item) :int
    {
        $diff = HistoricTransaction::difference($item, $this->interval);
        if ($diff === 0) {
            return 0;
        }
        if ($item->current_price > $item->base_price) {
            $proportion = 1 - ($item->current_price / (($item->base_price * $this->upperBound) - $item->base_price));
        } elseif ($item->current_price < $item->base_price) {
            $proportion = $item->current_price / ($item->base_price - ($item->base_price * $this->lowerBound));
        } else {
            $proportion = 1;
        }
        return $item->risk->swing * $proportion;
    }

    public function adjust()
    {
        foreach ($this->items as $item)
        {
            $change = $this->calcPercentChange($item);
        }
    }

}