<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
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
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/manage', [MenuController::class,'manage'])->name('menu.manage');
        Route::post('/', [MenuController::class,'store'])->name('menu.store');
        Route::get('/{menu}/edit', [MenuController::class,'edit'])->name('menu.edit');
        Route::put('/{menu}', [MenuController::class,'update'])->name('menu.update');
        Route::delete('/{menu}', [MenuController::class,'destroy'])->name('menu.destroy');

        Route::post('/{menu}/category', [CategoryController::class,'store'])->name('category.store');
        Route::put('/category/{category}', [CategoryController::class,'update'])->name('category.update');
        Route::delete('/category/{category}', [CategoryController::class,'destroy'])->name('category.destory');
        
        Route::post('/{menu}/item', [ItemController::class,'store'])->name('item.store');
        Route::put('/item/{item}', [ItemController::class,'update'])->name('item.update');
        Route::delete('/item/{item}', [ItemController::class,'destroy'])->name('item.destory');
    });
    Route::get('/', [MenuController::class,'index'])->name('menu.index');
    Route::get('/{menu}', [MenuController::class,'show'])->name('menu.show');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('/auth/check', [AuthController::class,'check'])->name('check');
});
