<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\GalleryController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/panel-de-control');
});

Route::get('/panel-de-control', function () {
    return view('control-panel');
});

Route::get('/iniciar-sesion', function () {
    return view('auth.login-register');
});

Route::post('/login', [AuthController::class, "login"])->name('auth.login');
Route::post('/signup', [AuthController::class, "signup"])->name('auth.signup');
Route::get('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('auth.verify_email');

Route::get('/añadir-articulo', [ProductController::class, 'create']);

Route::get('/editar-articulo', function () {
    return view('inventory.edit-item');
});

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

Route::get('/editar-slider-canvolt', [SliderController::class, 'create']);

Route::get('/canvolt-form/create', [SliderController::class, 'create'])->name('canvolt-form.create');
Route::post('/canvolt-form/store', [SliderController::class, 'store'])->name('canvolt-form.store');


Route::get('/administrar-galeria', [GalleryController::class, 'create']);

Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
