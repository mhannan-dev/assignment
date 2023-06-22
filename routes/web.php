<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;

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
    Route::resource('assignments', AssignmentController::class);
    Route::get('/assignment/filter', [AssignmentController::class, 'filter'])->name('filter');
    Route::any('/add/files/{id}', [AssignmentController::class, 'addFilesSave'])->name('add.files');

    Route::get('/attachment/download/{filename}', [AssignmentController::class, 'download'])->name('file.download');
    Route::get('/attachments/download/{filename}', [AssignmentController::class, 'downloadFiles'])->name('files.download');

    Route::post('/status/change', [AssignmentController::class, 'changeStatus'])->name('ajax.status');
});
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
