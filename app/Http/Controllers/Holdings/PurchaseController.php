<?php namespace App\Http\Controllers\Holdings;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/01/19
 * Time: 10:11
 */

use App\Http\Controllers\Controller;
use App\Models\UserHolding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Holding;

class PurchaseController extends Controller
{
    /**
     * Purchase the requested holding for the current user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function buy(Request $request)
    {
        $user = $request->user();
        $holding = Holding::find($request->get('id'));

        $userHolding = UserHolding::create([
            'user_id' => $user->id,
            'holding_id' => $holding->id,
            'rent_level' => 0,
            'discount_level' => 0,
            'xp_level' => 0,
            'last_collected_rent' => null,
            'copper_sank' => $holding->cost

        ]);
        $user->balance = $user->balance - $holding->cost;
        $user->save();

        return response()->json($userHolding, 200);
    }

    /**
     * Upgrade a holding attribute
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function upgrade(Request $request)
    {
        // Get data
        $user = $request->user();
        $userHolding = UserHolding::find($request->get('user_holding_id'));
        $holding = $userHolding->holding;
        $type = $request->get('type');

        // Calculate costs
        if ($type === 'rent') {
            $userHolding->rent_level = $userHolding->rent_level++;
            $cost = $holding->cost * (($userHolding->rent_level + 1) * $holding->rent_cost_increment);
        } elseif ($type === 'discount') {
            $userHolding->discount_level = $userHolding->discount_level++;
            $cost = $holding->cost * (($userHolding->discount_level + 1) * $holding->discount_cost_increment);
        } elseif ($type === 'xp') {
            $userHolding->xp_level = $userHolding->xp_level++;
            $cost = $holding->cost * (($userHolding->xp_level + 1) * $holding->xp_cost_increment);
        }

        // Update models
        $user->balance = $user->balance - $cost;
        $user->save();
        $userHolding->save();

        // Return response
        return response()->json($userHolding, 200);
    }
}