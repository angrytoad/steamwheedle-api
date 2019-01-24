<?php namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\HistoricTransaction;
use App\Models\ItemPurchase;
use App\Models\Item;
use App\Models\User;
use App\Models\UserHolding;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TradeController extends Controller {

    /**
     * Handle user purchase requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Handle user sell requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sell(Request $request)
    {
        $purchase = ItemPurchase::find($request->get('item_purchase_id'));
        $quantity = $request->get('quantity');
        $user = $request->user();

        $current_value = $quantity * $purchase->item->current_price;
        $buy_value = $quantity * $purchase->buy_price;
        $profit = $current_value - $buy_value;

        $this->doAhCut($user, $purchase->item, $buy_value, $profit);

        $purchase->current = $purchase->current - $quantity;
        $purchase->save();
        $rem = $purchase->current;

        $historic = new HistoricTransaction();
        $historic->item_id = $purchase->item_id;
        $historic->item_purchase_id = $purchase->id;
        $historic->quantity = $quantity;
        $historic->type = false;
        $historic->save();

        $this->addLevelExperience($user, $profit, $purchase->item);

        return response()->json(['balance' => $user->balance, 'remaining' => $rem, 'profit' => $profit], 200);
    }

    /**
     * Apply the AH cut taking holdings into account
     *
     * @param User $user
     * @param Int $buyVal
     * @param Int $profit
     */
    private function doAhCut(User $user, Item $item, Int $buyVal, Int $profit)
    {
        $holdings = UserHolding::where('user_id', $user->id)->get();
        $holding = $holdings->filter(function ($holding) use ($item) {
            return $holding->holding->item_id === $item->id;
        });
        if (!empty($holding->first())) {
            $holding = $holding->first();
            $cut = env('cut', 0.05) - ($holding->discount_level * $holding->holding->discount_level_increment);
            $user->balance =  $user->balance + ((1 - $cut) * $buyVal + $profit);
        } else {
            $user->balance =  $user->balance + ((1 - env('cut', 0.05)) * $buyVal + $profit);
        }
        $user->profit = $user->profit + $profit;
        $user->save();
    }

    /**
     * Calculate xp for a sale and add it to a users account
     *
     * @param User $user
     * @param Int $profit
     */
    private function addLevelExperience(User $user, Int $profit, Item $item){
        $experience = floor($profit/10);

        $holding = UserHolding::where('item_id', $item->id)->where('user_id', $user->id)->first();
        if (!empty($holding)) {
            $experience = $experience + ($experience * (1 + ($holding->xp_level * $holding->holding->xp_level_increment)));
        }

        $levels = config('levels');
        while($experience > 0){
            if($user->level < 60){
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
            }else{
                $experience = 0;
            }
        }
        $user->save();
    }

}