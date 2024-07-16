<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\DirectionsController;

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
Route::post('/photos/upload', [PhotoController::class, 'upload']);
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/directions', function () {
    return view('directions');
});
