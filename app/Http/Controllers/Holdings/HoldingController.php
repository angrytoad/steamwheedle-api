<?php namespace App\Http\Controllers\Holdings;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/01/19
 * Time: 10:11
 */

use App\Http\Controllers\Controller;
use App\Models\Holding;
use App\Models\UserHolding;
use App\Models\User;
use Illuminate\Http\Request;

class HoldingController extends Controller
{
    /**
     * Returns a modified list of all holdings
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $holdings = Holding::all()->sortBy('cost');
        return response()->json($holdings, 200);
    }

    /**
     * Returns a users holdings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function users(Request $request)
    {
        return response()->json($request->user()->holdings, 200);
    }

    /**
     * Handle user rent collection requests
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function collect(Request $request)
    {
        $userHoldings = $request->get('user_holding_ids');
        $response = [];
        foreach ($userHoldings as $id) {
            // Get the Userholding
            $userHolding = UserHolding::find($id);
            // Check if the rent level has increased beyond 0
            if ($userHolding->rent_level <= 0) {
                $response[$id] = ['message' => 'This holding is not high enough level.', 'collected' => 0];
            }
            // Check if it has been 8 hours or more since the last collection or is null
            if (is_null($userHolding->last_collected_rent) || $userHolding->last_collected_rent->diffInSeconds(now()) >= 28800) {
                $collected = $this->doCollection($request->user(), $userHolding);
                $response[$id] = ['message' => 'Rent collected', 'collected' => $collected];
            } else {
                $response[$id] = ['message' => 'This cannot be collected right now.', 'collected' => 0];
            }
        }
        return response()->json($response, 200);
    }

    /**
     * Add the collected balance to the users account and reset the last collection timer to now
     *
     * @param User $user
     * @param UserHolding $holding
     * @return int
     */
    private function doCollection(User $user, UserHolding $holding) :int
    {
        // Calculate amount
        $amount = ceil($holding->holding->cost * ($holding->rent_level * $holding->holding->rent_level_increment));
        // Update and save models
        $user->balance = $user->balance + $amount;
        $user->save();
        $holding->last_collected_rent = now();
        $holding->save();

        return $amount;
    }
}