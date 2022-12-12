<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/nieuws', [NewsController::class, 'index'])->name('news');
Route::get('/nieuws/{post_slug}', [NewsController::class, 'slugPage'])->name('newsdetail');
Route::get('/tarieven', [PricesController::class, 'index'])->name('prices');
Route::get('/reglement', [RegulationController::class, 'index'])->name('regulations');
Route::get('/impressies', [ImpressionController::class, 'index'])->name('impressions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reserveren', [ReservationController::class, 'index'])->name('reservation');
    Route::post('/reserveren/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
