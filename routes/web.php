<?php

use App\Http\Controllers\Dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\Dashboard\NewsController as DashboardNewsController;
use App\Http\Controllers\Dashboard\PricesController as DashboardPricesController;
use App\Http\Controllers\Dashboard\RegulationController as DashboardRegulationController;
use App\Http\Controllers\Dashboard\ReservationController as DashboardReservationController;
use App\Http\Controllers\Dashboard\ImpressionController as DashboardImpressionController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\ReservationController;
use App\Http\Middleware\Admin;
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
    Route::post('/reserveren/delete', [ReservationController::class, 'delete'])->name('reservation.delete');
    Route::post('/reserveren/change', [ReservationController::class, 'update'])->name('reservation.change');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/dashboard', [DashboardHomeController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/nieuws', [DashboardNewsController::class, 'index'])->name('dashboard.news');
    Route::get('/dashboard/nieuws/nieuwepost',[DashboardNewsController::class, 'newPost'])->name('dashboard.news.newpost');
    Route::get('/dashboard/nieuws/{post_slug}',[DashboardNewsController::class, 'detailedPage'])->name('dashboard.newsdetail');
    Route::post('/dashboard/nieuws/opslaan',[DashboardNewsController::class, 'update'])->name('dashboard.news.save');
    Route::post('/dashboard/nieuws/new',[DashboardNewsController::class, 'create'])->name('dashboard.news.new');

    Route::get('/dashboard/tarieven', [DashboardPricesController::class, 'index'])->name('dashboard.prices');
    Route::get('/dashboard/tarieven/{id}', [DashboardPricesController::class, 'detailedPage'])->name('dashboard.prices.pricedetail');
    Route::post('/dashboard/tarieven/new', [DashboardPricesController::class, 'create'])->name('dashboard.prices.new');
    Route::post('/dashboard/tarieven/update', [DashboardPricesController::class, 'update'])->name('dashboard.prices.update');

    Route::get('/dashboard/reserveringen', [DashboardReservationController::class, 'index'])->name('dashboard.reservations');
    Route::get('/dashboard/reserveringen/{id}', [DashboardReservationController::class, 'detailedPage'])->name('dashboard.reservations.detail');
    Route::post('/dashboard/reserveringen/new', [DashboardReservationController::class, 'create'])->name('dashboard.reservations.new');
    Route::post('/dashboard/reserveringen/update', [DashboardReservationController::class, 'update'])->name('dashboard.reservations.update');

    Route::get('/dashboard/reglementen', [DashboardRegulationController::class, 'index'])->name('dashboard.regulations');
    Route::get('/dashboard/reglementen/{id}', [DashboardRegulationController::class, 'detailedPage'])->name('dashboard.regulations.detail');
    Route::post('/dashboard/reglementen/new', [DashboardRegulationController::class, 'create'])->name('dashboard.regulations.new');
    Route::post('/dashboard/reglementen/update', [DashboardRegulationController::class, 'update'])->name('dashboard.regulations.update');

    Route::get('/dashboard/impressies', [DashboardImpressionController::class, 'index'])->name('dashboard.impressions');
    Route::post('/dashboard/impressies/new', [DashboardImpressionController::class, 'create'])->name('dashboard.impressions.new');

    Route::get('/dashboard/gebruikers', [DashboardUserController::class, 'index'])->name('dashboard.users');
    Route::get('/dashboard/gebruikers/{id}', [DashboardUserController::class, 'detailedPage'])->name('dashboard.users.detail');
    Route::post('/dashboard/gebruikers/new', [DashboardUserController::class, 'create'])->name('dashboard.users.new');
    Route::post('/dashboard/gebruikers/update', [DashboardUserController::class, 'update'])->name('dashboard.users.update');

    Route::post('/nieuws/delete', [DashboardNewsController::class, 'delete'])->name('news.delete');
    Route::post('/tarief/delete', [DashboardPricesController::class, 'delete'])->name('prices.delete');
    Route::post('/reglement/delete', [DashboardRegulationController::class, 'delete'])->name('regulations.delete');
    Route::post('/reserveringen/delete', [DashboardReservationController::class, 'delete'])->name('reservations.delete');
    Route::post('/impressies/delete', [DashboardImpressionController::class, 'delete'])->name('impressions.delete');
    Route::post('/gebruikers/delete', [DashboardUserController::class, 'delete'])->name('users.deactivate');
    Route::post('/gebruikers/activate', [DashboardUserController::class, 'activate'])->name('users.activate');
});

require __DIR__.'/auth.php';
