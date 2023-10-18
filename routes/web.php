<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenizeController;

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

Route::get('/japanese/tokenize', function () {
    return view('japaneseTokenize');
});

Route::get('words', [TokenizeController::class, 'index']);
