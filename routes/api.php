<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;


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

Route::post('/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/list', [UrlShortenerController::class, 'list']);
Route::get('/stats', [UrlShortenerController::class, 'stats']);
Route::get('/short-url-statistics/{shortUrl}', [UrlShortenerController::class, 'getShortUrlStatistics']);