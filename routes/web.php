<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InventoryController;

use Illuminate\Support\Facades\Route;

Route::get('/temporal-token/{token}', [AuthController::class, 'temporalToken'])->name('auth.temporal_token');

// All routes need to be authenticated
Route::middleware('auth')->group(function () {
    
    Route::get('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/', function () {
        return redirect('/panel');
    });
    
    Route::get('/panel', function () {
        return view('dashboard');
    });
    
    Route::get('/añadir-articulo', [ProductController::class, 'create']);
    Route::get('/inventario', [InventoryController::class, 'index']);
    Route::get('/inventario/edit/{id}', [InventoryController::class, 'edit'])->name('inventario.edit');
    Route::delete('/inventario/destroy/{id}', [InventoryController::class, 'destroy'])->name('inventario.destroy');
    
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

    
    Route::get('/editar-slider-canvolt', [SliderController::class, 'create']);
    
    Route::get('/canvolt-form/create', [SliderController::class, 'create'])->name('canvolt-form.create');
    Route::post('/canvolt-form/store', [SliderController::class, 'store'])->name('canvolt-form.store');
    
    
    Route::get('/administrar-galeria', [GalleryController::class, 'create']);
    
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    
    
    // Ruta para los tickets
    Route::get('/generar-ticket', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/crear-ticket', [TicketController::class, 'store'])->name('tickets.store');
});