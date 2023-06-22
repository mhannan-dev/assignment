<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

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
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::any('/user/role/change', [UserController::class, 'changeRole'])->name('role.status');
    Route::resource('assignments', TodoController::class);
    Route::get('/assignment/filter', [TodoController::class, 'filter'])->name('filter');
    Route::any('/add/files/{id}', [TodoController::class, 'addFilesSave'])->name('add.files');

    Route::get('/attachment/download/{filename}', [TodoController::class, 'download'])->name('file.download');
    Route::get('/attachments/download/{filename}', [TodoController::class, 'downloadFiles'])->name('files.download');

    Route::post('/status/change', [TodoController::class, 'changeStatus'])->name('ajax.status');
});
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
