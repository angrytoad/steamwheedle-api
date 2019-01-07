<?php namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 03/12/18
 * Time: 21:45
 */


class HistoricTransaction extends Model {

    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_id',
        'quantity',
        'type'
    ];

    /**
     * Static function for calculating the different in buys and sells over a specified period
     *
     * @param Item $item
     * @param int $period
     * @return int
     */
    public static function difference(Item $item, int $period) :int
    {
        // Fetch all historic transactions that occurred for that item in the previous interval period
        $items = self::where('item_id', $item->id)->where('updated_at', '>=', Carbon::createFromTimestamp(now()->timestamp - $period))->get();
        $total = 0;
        foreach ($items as $item) {
            // The type property defined if a transaction was a buy or a sell: 0 - Sell, 1 - Buy
            if ($item->type === 1) {
                $total += $item->quantity;
            } else {
                $total -= $item->quantity;
            }
        }
        return $total;
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function item_purchase()
    {
        return $this->belongsTo(ItemPurchase::class);
    }

}