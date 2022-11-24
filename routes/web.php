<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/recent-logs', [App\Http\Controllers\Check::class, 'getRecentLogs']);
Route::get('/time-since-last-comments-scanning', [App\Http\Controllers\Check::class, 'getTimeSinceLastCommentsScanning']);

Route::get('ellis', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate');
});
