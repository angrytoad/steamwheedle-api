<?php

namespace App\Http\Middleware;

use App\Models\Item;
use Closure;

class HasFunds
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
            'quantity' => 'required|integer',
            'item_id' => 'required|string'
        ]);
        if (!$item = Item::find($data['item_id'])) {
            return response()->json(['message' => 'Item_id must be valid'], 400);
        }
        if ($data['quantity'] * $item->current_price > $request->user()->balance) {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }

        return $next($request);
    }
}
