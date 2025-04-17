<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DetailSaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\Sale;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// })->name('home');

Route::get('/', function(){
    return view('login');
});

Route::get('/error-permission', function(){
    return view('error.404');
})->name('error-permission');

Route::post('/login-auth',[LoginController::class, 'store'])->name('login-auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// route agar ketika sudah login tidak bisa ke page login, harus logout dulu
Route::middleware('IsGuest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login-auth', [LoginController::class, 'store'])->name('login-auth');
});

// route yang bisa diakses dua role ( admin, kasir ) setelah login
Route::middleware('IsLogin')->group(function() {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/home', [UserController::class, 'adminPage'])->name('home');
    // Route::get('/home',function() {
    //     return view('home');
    // })->name('home');

    Route::prefix('/product')->name('product.')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('index');
    });
    Route::prefix('/sale')->name('sale.')->group(function(){
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/exportPDF/{id}', [SaleController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/lihat/{id}/', [SaleController::class, 'lihat'])->name('lihat');

    });
});

// route yang bisa diakses role admin saja
Route::middleware(['IsLogin', 'IsAdmin'])->group(function(){
    Route::prefix('/product')->name('product.')->group(function(){
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('delete');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [ProductController::class, 'update'])->name('update');
        Route::patch('/updateStok/{id}', [ProductController::class, 'updateStok'])->name('updateStok');
    });
    Route::prefix('/user')->name('user.')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
    });
});

// route yang bisa diakses role kasir saja
Route::middleware(['IsLogin','IsStaff'])->group(function(){
    Route::prefix('/DetailSale')->name('DetailSale.')->group(function(){
        Route::get('/', [DetailSaleController::class, 'index'])->name('index');
    });
    Route::controller(SaleController::class)->prefix('/sale')->name('sale.')->group(function(){
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store4crud')->name('store');
        Route::get('/nextCreate/{id}', 'nextCreate')->name('next-create');
        Route::post('/nextCreate/{id}', 'submitNextCreate')->name('submit-next');
        Route::get('/print/{id}', 'print')->name('print');
        Route::get('/exportExcel', 'exportExcel')->name('exportExcel');

    });
});

