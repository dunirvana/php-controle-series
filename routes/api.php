<?php

use Illuminate\Contracts\Auth\Authenticatable;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/series', \App\Http\Controllers\Api\SeriesController::class);

    Route::get('/series/{id}/seasons', [\App\Http\Controllers\Api\SeriesController::class, 'seasons']);
    Route::get('/series/{id}/episodes', [\App\Http\Controllers\Api\SeriesController::class, 'episodes']);
    Route::patch('/episodes/{episode}/watched', function (\App\Models\Episode $episode, Request $request, Authenticatable $user) {

        if (!$user->tokenCan('series:update')) {
            return response()->json('Unauthorized', 401);
        }

        $episode->watched = $request->watched;
        $episode->save();

        return $episode;
    });

    Route::post('/upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);
});


Route::post('/login', function(Request $request){
    $credentials = $request->only(['email', 'password']);
    if (Auth::attempt($credentials) === false) {
        return response()->json('Unauthorized', 401);
    }

    $user = Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token', ['series:create', 'series:update', 'series:delete']);

    return response()->json($token->plainTextToken);
});
