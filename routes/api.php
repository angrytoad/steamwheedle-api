<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get Current User
Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

// Return the levels configuration
Route::middleware(['auth:api'])->get('/levels', function (Request $request) {
    return config('levels');
});

// Test route?
$this->group(['middleware' => [], 'prefix' => '/test'], function() {
    $this->get('/','Test\TestController@test');
});

// Routes for user login and registration
$this->group(['middleware' => [], 'prefix' => '/user'], function() {
    $this->post('/register','User\RegisterController@post');
    $this->post('/login','User\LoginController@login');
});

// Routes for interacting with the auction house
$this->group(['middleware' => ['auth:api'], 'prefix' => 'auction'], function () {
    $this->get('/categories', 'Category\CategoryController@fetch');
    $this->get('/update', 'Time\TimeController@countdown');

    $this->group(['middleware' => 'json'], function () {
        $this->post('/items', 'Item\ItemController@filter');;
        $this->post('/buy', 'Item\TradeController@buy')->middleware('has-funds');
        $this->post('/sell', 'Item\TradeController@sell')->middleware('has-stock');
    });
});

// Routes for getting user information
$this->group(['middleware' => 'auth:api'], function () {
    $this->group(['prefix' => 'user'], function () {
        $this->get('/purchases', 'User\PurchasesController@purchases');
        $this->get('/holdings', 'Holdings\HoldingController@users');
    });
});

//Routes for interacting with the holdings system
$this->group(['middleware' => 'auth:api', 'prefix' => 'holdings'], function () {
    $this->get('/', 'Holdings/HoldingController@list');
    $this->group(['middleware' => 'json'], function () {
        $this->post('/collect', 'Holdings\HoldingController@collect');
        $this->post('/buy', 'Holdings\PurchaseController@buy');
        $this->post('/upgrade', 'Holdings\PurchaseController@upgrade');
    });
});