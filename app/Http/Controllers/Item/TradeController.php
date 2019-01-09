<?php namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\HistoricTransaction;
use App\Models\ItemPurchase;
use App\Models\Item;
use App\Models\User;
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

        $historic = new HistoricTransaction();
        $historic->item_id = $item->id;
        $historic->item_purchase_id = $holding->id;
        $historic->quantity = $request->get('quantity');
        $historic->type = true;
        $historic->save();

        return response()->json(['balance' => $user->balance], 200);
    }

    public function sell(Request $request)
    {
        $purchase = ItemPurchase::find($request->get('item_purchase_id'));
        $quantity = $request->get('quantity');
        $user = $request->user();

        $current_value = $quantity * $purchase->item->current_price;
        $buy_value = $quantity * $purchase->buy_price;
        $profit = $current_value - $buy_value;

        $user->balance =  $user->balance + ((1 - env('cut', 0.05)) * $buy_value + $profit);
        $user->profit = $user->profit + $profit;
        $user->save();

        $this->addLevelExperience($user, $profit);

        $purchase->current = $purchase->current - $quantity;
        $purchase->save();
        $rem = $purchase->current;

        $historic = new HistoricTransaction();
        $historic->item_id = $purchase->item_id;
        $historic->item_purchase_id = $purchase->id;
        $historic->quantity = $quantity;
        $historic->type = false;
        $historic->save();

        return response()->json(['balance' => $user->balance, 'remaining' => $rem, 'profit' => $profit], 200);
    }

    private function addLevelExperience(User $user, Int $profit){
        $experience = floor($profit/10);
        $levels = config('levels');
        while($experience > 0){
            $newTotal = $user->current_experience + $experience;
            $levelupRequired = $levels[$user->level];
            if($newTotal >= $levelupRequired){
                $user->level += 1;
                $experience -= ($levelupRequired - $user->current_experience);
                $user->current_experience = 0;
            }else{
                $user->current_experience = $newTotal;
                $experience = 0;
            }
        }
        $user->save();
    }

}