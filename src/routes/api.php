<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/search/{name}', [TicketController::class, 'search']);
Route::get('/tickets/sort/{filter}', [TicketController::class, 'sort']);
Route::post('/tickets/filters/', [TicketController::class, 'filterBy']);
Route::post('/tickets', [TicketController::class, 'store']);
Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
