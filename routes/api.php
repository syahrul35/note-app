<?php

use App\Http\Controllers\API\NotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware(['auth:sanctum', 'role:admin,editor,viewer'])->group(function () {
    Route::get('/notes', [NotesController::class, 'index'])->name('notes.index');
});

Route::middleware(['auth:sanctum', 'role:admin,editor'])->group(function () {
    Route::post('/notes', [NotesController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NotesController::class, 'show'])->name('notes.show');
    Route::put('/notes/{note}', [NotesController::class, 'update'])->name('notes.update');
    Route::delete('/notes{note}', [NotesController::class, 'destroy'])->name('notes.destroy');
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});
