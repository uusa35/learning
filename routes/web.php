<?php

use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\Backend\MedicineController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PrescriptionController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SlotController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
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

Route::group(['middleware' => ['role:doctor|receptionest', 'auth'], 'as' => 'backend.'], function () {
    Route::resource('user', UserController::class)->only('show');
    Route::resource('attribute', AttributeController::class);
    Route::resource('certificate', CertificateController::class);
    Route::resource('slot', SlotController::class);
    Route::resource('appointment', AppointmentController::class);
    Route::resource('prescription', PrescriptionController::class);
    Route::resource('medicine', MedicineController::class);
    Route::resource('order', OrderController::class);
    Route::resource('tag', TagController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('image', ImageController::class);
    Route::resource('setting', SettingController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['middleware' => ['role:super|admin']], function () {
        Route::resource('user', UserController::class);
        Route::get("toggle/activate", [HomeController::class, "toggleActivate"])->name("toggle.activate");
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->middleware(['verified'])->name('home');
        Route::get('/sample', function () {
            return Inertia::render('SamplePage');
        })->name('sample');
    });
});





Route::group(['as' => 'frontend.'], function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('home');
    Route::group(['middleware' => 'auth'], function () {
        Route::resource('appointment', AppointmentController::class)->except(['delete']);
    });
});

Route::get("/lang/{lang}", [HomeController::class, "changeLang"])->name("change.lang");
require __DIR__ . '/auth.php';
