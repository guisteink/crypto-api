<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{coin}/most-recent', [CryptoController::class, 'mostRecent'])->name('Most Recent Price');
Route::get('/{coin}/history', [CryptoController::class, 'historyPrice'])->name('History Price');