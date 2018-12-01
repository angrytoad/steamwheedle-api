<?php namespace App\Services;

use App\Models\Item;
use App\Models\ItemPurchase;

class PriceAdjustmentService {

    protected $items;
    protected $change = [];

    //config options
    protected $rounding;
    protected $interval;

    public function __construct(array $config)
    {
        $this->configure($config);
        $this->items = Item::all();
    }

    private function configure(array $config) :void
    {
        $this->rounding = $config['rounding'];
        $this->interval = $config['interval'];
    }

    private function calcPercentChange(Item $item) :int
    {
        $diff = ItemPurchase::difference($item, $this->interval);
    }

    public function adjust()
    {
        foreach ($this->items as $item)
        {
            $change = $this->calcPercentChange($item);
        }
    }

}