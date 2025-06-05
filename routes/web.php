<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoapController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/soap', [SoapController::class, 'handle']);
Route::get('/soap', [SoapController::class, 'handle']);
