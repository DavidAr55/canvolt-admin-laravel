<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::get('dashboard-data/services', 'Api\V1\DashboardDataController@services');
    Route::get('dashboard-data/products', 'Api\V1\DashboardDataController@products');
    Route::get('dashboard-data/month-transactions', 'Api\V1\DashboardDataController@monthTransactions');
});
