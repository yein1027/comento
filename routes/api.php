<?php

use App\Http\Controllers\Board\BoardAPIController;
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

Route::prefix('/v1/board')->group(function () {

    Route::get('/questions', [BoardAPIController::class, 'index']);

    Route::middleware('auth')->group(function () {
        Route::post('/questions', [BoardAPIController::class, 'store']);
        Route::post('/question/answer', [BoardAPIController::class, 'storeAnswer']);
        Route::delete('/question/answer/{boardAnswerId}', [BoardAPIController::class, 'destroy']);
    });

});

