<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/series', \App\Http\Controllers\Api\SeriesController::class);
Route::get('/series/{id}/seasons', [\App\Http\Controllers\Api\SeriesController::class, 'seasons']);

Route::post('/upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);
