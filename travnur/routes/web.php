<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TravelPackageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  [HomeController::class, 'index'])->name('home');
Route::get('/detail{slug}',  [DetailController::class, 'index'])->name('detail');
// Route::get('/checkout',  [CheckoutController::class, 'index'])->name('checkout');
// Route::get('/checkout/success',  [CheckoutController::class, 'success'])->name('checkout-success');

Route::get('/checkout/{id}', [CheckoutController::class, 'process'])
  ->name('checkout_process')
  ->middleware(['auth', 'verified']);

Route::post('/checkout/{id}', [CheckoutController::class, 'index'])
  ->name('checkout')
  ->middleware(['auth', 'verified']);

Route::get('/checkout/create/{detail_id}', [CheckoutController::class, 'create'])
  ->name('checkout-create')
  ->middleware(['auth', 'verified']);

Route::post('/checkout/remove/{detail_id}', [CheckoutController::class, 'remove'])
  ->name('checkout-remove')
  ->middleware(['auth', 'verified']);

Route::get('/checkout/confirm/{id}', [CheckoutController::class, 'success'])
  ->name('checkout-success')
  ->middleware(['auth', 'verified']);


Route::prefix('admin')
  // ->namespace('Admin')
  ->middleware(['auth', 'admin'])
  ->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
      ->name('dashboard');
    Route::resource('travel-package', TravelPackageController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('transaction', TransactionController::class);
  });

// Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'admin']);
// Route::resource('travel-package', TravelPackageController::class)->middleware(['auth', 'admin']);

Auth::routes(['verify' => true]);