<?php namespace App\Http\Controllers\User;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 28/11/18
 * Time: 23:18
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class PurchasesController extends Controller {

    public function purchases(Request $request)
    {
        $purchases = $request->user()->purchases->sortBy('buy_price')->groupBy('item_id');
        $return = [];
        foreach ($purchases as $id => $arr) {
            $return[Item::find($id)->name] = $arr;
        }
        return response()->json($return, 200);
    }

}