<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::post('/sanctum/token', TokenController::class);

Route::post('/login', [AuthController::class,'login'])->name('login');
Route::post('/register', [AuthController::class,'register'])->name('register');

Route::prefix('menu')->group(function(){
    Route::get('/', [MenuController::class,'index'])->name('menu.index');
    Route::get('/{menu}', [MenuController::class,'show'])->name('menu.show');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('/auth/check', [AuthController::class,'check'])->name('check');
});
