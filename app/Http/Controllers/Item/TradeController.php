<?php namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Holding;
use App\Models\Item;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TradeController extends Controller {

    public function buy(Request $request)
    {
        $item = Item::find($request->get('item_id'));
        $user = $request->user();

        $holding = new Holding;
        $holding->id = Uuid::uuid4();
        $holding->quantity = $request->get('quantity');
        $holding->buy_price = $item->current_price;
        $holding->item_id = $item->id;
        $holding->user_id = $user->id;
        $holding->save();
        $user->balance = $user->balance - ($item->current_price * $request->get('quantity'));
        $user->save();

        return response()->json(['balance' => $user->balance], 200);
    }

}