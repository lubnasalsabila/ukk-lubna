<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProductController;

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

Route::get('/', function(){
    return view('login');
});

Route::post('/login-auth', [LoginController::class, 'store'])->name('login-auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('IsLogin')->group(function(){
    Route::get('/home', function(){
        return view('home');
    })->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [ProductController::class, 'index'])->name('index');
});

Route::middleware('IsGuest')->group(function(){
    Route::get('/', function(){
        return view('login');
    })->name('login');
});

Route::middleware(['IsLogin', 'IsAdmin'])->group(function() {
    Route::prefix('/user')->name('user.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/product')->name('product.')->group(function() {
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('delete');
    });
});

Route::middleware('IsLogin', 'IsStaff')->group(function(){
});
