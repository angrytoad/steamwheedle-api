<?php namespace App\Models;

use App\Traits\Uuids;
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

    public static function difference(Item $item, int $period) :int
    {
        $items = Self::where('id', $item->id)->where('updated_at', '>=', now() - $period)->get();
        $total = 0;
        foreach ($items as $item) {
            if ($item->type) {
                $total =+ $item->quantity;
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