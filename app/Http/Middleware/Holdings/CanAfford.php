<?php

namespace App\Http\Middleware\Holdings;

use App\Models\UserHolding;
use Closure;
use App\Models\Holding;

class CanAfford
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('holding_id')) {
            // For purchases
            $holding = Holding::find($request->get('id'));
            $user = $request->user();
            if ($user->balance < $holding->cost) {
                return response()->json(['message' => 'You cannot afford this.'], 422);
            }
        } elseif ($request->has('user_holding_id')) {
            // For upgrades
            $user = $request->user();
            $userHolding = UserHolding::find($request->get('user_holding_id'));
            $holding = $userHolding->holding;
            $type = $request->get('type');

            if ($type === 'rent') {
                if ($userHolding->rent_level === $holding->rent_max_level) {
                    return response()->json(['message' => 'This is at max level'], 422);
                }
                $cost = $holding->cost * (($userHolding->rent_level + 1) * $holding->rent_cost_increment);
                if ($user->balance < $cost) {
                    return response()->json(['message' => 'You cannot afford this.'], 422);
                }
            } elseif ($type === 'discount') {
                if ($userHolding->discount_level === $holding->discount_max_level) {
                    return response()->json(['message' => 'This is at max level'], 422);
                }
                $cost = $holding->cost * (($userHolding->discount_level + 1) * $holding->discount_cost_increment);
                if ($user->balance < $cost) {
                    return response()->json(['message' => 'You cannot afford this.'], 422);
                }
            } elseif ($type === 'xp') {
                if ($userHolding->xp_level === $holding->xp_max_level) {
                    return response()->json(['message' => 'This is at max level'], 422);
                }
                $cost = $holding->cost * (($userHolding->xp_level + 1) * $holding->xp_cost_increment);
                if ($user->balance < $cost) {
                    return response()->json(['message' => 'You cannot afford this.'], 422);
                }
            } else {
                return response()->json(['message' => 'What are you upgrading?'], 422);
            }
        }

        return $next($request);
    }
}
