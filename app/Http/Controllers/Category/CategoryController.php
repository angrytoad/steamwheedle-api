<?php namespace App\Http\Controllers\Category;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 25/11/18
 * Time: 23:16
 */

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller {

    /**
     * Handles api requests for categories
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function fetch()
    {
        return response()->json(Category::all(), 200);
    }

}