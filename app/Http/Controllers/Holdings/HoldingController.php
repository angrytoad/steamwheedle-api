<?php namespace App\Http\Controllers\Holdings;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/01/19
 * Time: 10:11
 */

use App\Http\Controllers\Controller;
use App\Models\Holding;
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

    public function collect()
    {

    }
}