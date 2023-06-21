<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;

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
Route::middleware('auth')->group(function () {
    Route::resource('assignments', TodoController::class);
    Route::get('/attachment/download/{filename}', [TodoController::class, 'download'])->name('file.download');
    Route::post('/status/change', [TodoController::class, 'changeStatus'])->name('ajax.status');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
