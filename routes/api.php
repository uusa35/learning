<?php

use App\Events\OrderPaid;
use App\Events\OrderShipped;
use App\Notifications\OrderCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/all/user', function (Request $request) {
    return User::all();
});
Route::get('order/created', function () {
    $user = User::whereId(request()->id)->first();
    event(new OrderPaid(request()->message, $user->id));
    $user->notify(new OrderCreated(request()->message, $user->id));
    return response()->json(['message' => request()->message], 200);
});
