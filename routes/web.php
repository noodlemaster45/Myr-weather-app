<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\weatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/weather', [weatherController::class, 'index'])->name('weather');

//cache debug
Route::get('/cache-check/{city}', function ($city) {
    return response()->json([
        'cached_weather' => Cache::get("weather_{$city}"),
        'cached_forecast' => Cache::get("forecast_{$city}"),
        'cache_exists' => Cache::has("weather_{$city}") ? 'Yes' : 'No'
    ]);
});