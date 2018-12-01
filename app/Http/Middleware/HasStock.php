<?php

namespace App\Http\Middleware;

use App\Models\ItemPurchase;
use Closure;

class HasStock
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
        $data = $request->validate([
            'item_purchase_id' => 'required|string',
            'quantity' => 'required|integer'
        ]);

        if (!$purchase = ItemPurchase::find($data['item_purchase_id'])) {
            return response()->json(['message' => 'No purchase found'], 400);
        }
        if ($purchase->user->id !== $request->user()->id) {
            return response()->json(['message' => 'This is not yours'], 400);
        }
        if ($data['quantiy'] > $purchase->current) {
            return response()->json(['message' => 'You don\'t own that much.'], 400);
        }
        return $next($request);
    }
}
