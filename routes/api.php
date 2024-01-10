<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::prefix('/v1')->group(
//     function () {
//         Route::post('/login', [App\Http\Controllers\Api\Auth\LoginController::class, 'login'])->name('login');
//         Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register'])->name('register');
//         Route::post('/logout', [App\Http\Controllers\Api\Auth\LoginController::class, 'logout'])->name('logout');
//         Route::post('/refresh', [App\Http\Controllers\Api\Auth\LoginController::class, 'refresh'])->name('refresh');
//         Route::get('/user', [App\Http\Controllers\Api\Auth\LoginController::class, 'user'])->name('user');
//         Route::get('/users', [App\Http\Controllers\Api\UserController::class, 'index'])->name('users');
//         Route::get('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'show'])->name('users.show');
//         Route::post('/users', [App\Http\Controllers\Api\UserController::class, 'store'])->name('users.store');
//         Route::put('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'update'])->name('users.update');
//         Route::delete('/users/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy'])->name('users.destroy');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//         Route::get('/users/{id}/edit', [App\Http\Controllers\Api\UserController::class, 'edit'])->name('users.edit');
//     }
// );