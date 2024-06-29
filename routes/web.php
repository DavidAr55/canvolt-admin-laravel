<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

