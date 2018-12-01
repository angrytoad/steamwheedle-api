<?php namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\ItemPurchase;
use App\Models\Item;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TradeController extends Controller {

    public function buy(Request $request)
    {
        $item = Item::find($request->get('item_id'));
        $user = $request->user();

        $holding = new ItemPurchase;
        $holding->quantity = $request->get('quantity');
        $holding->current = $holding->quantity;
        $holding->buy_price = $item->current_price;
        $holding->item_id = $item->id;
        $holding->user_id = $user->id;
        $holding->save();
        $user->balance = $user->balance - ($item->current_price * $request->get('quantity'));
        $user->save();

        return response()->json(['balance' => $user->balance], 200);
    }

    public function sell(Request $request)
    {
        $purchase = ItemPurchase::find($request->get('item_purchase_id'));
        $quantity = $request->get('quantity');
        $user = $request->user();

        $value = $quantity * $purchase->item->current_price;
        $user->balance = $user->balance + $value;

        $profit = $value - ($quantity * $purchase->buy_price);
        $user->profit = $user->profit + $profit;

        $user->save();

        $purchase->current = $purchase->current - $quantity;
        $purchase->save();
        $rem = $purchase->current;

        return response()->json(['balance' => $user->balance, 'remaining' => $rem, 'profit' => $profit], 200);
    }

}