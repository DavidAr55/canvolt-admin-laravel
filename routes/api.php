<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::get('dashboard-data/services', 'Api\V1\DashboardDataController@services');
    Route::get('dashboard-data/products', 'Api\V1\DashboardDataController@products');
    Route::get('dashboard-data/purchases', 'Api\V1\DashboardDataController@purchases');
    Route::get('dashboard-data/month-transactions', 'Api\V1\DashboardDataController@monthTransactions');
    Route::post('dashboard-data/gallery', 'Api\V1\DashboardDataController@gallery');
    Route::get('dashboard-data/service-and-product-sales', 'Api\V1\DashboardDataController@serviceAndProductSales');

    Route::get('tasks/today', 'Api\V1\TaskController@getTasksForToday');
    Route::post('tasks/{id}/toggle', 'Api\V1\TaskController@toggleTaskCompletion');
    Route::post('tasks/add', 'Api\V1\TaskController@addTask');
    Route::post('tasks/{id}/complete', 'Api\V1\TaskController@markAsCompleted');
    Route::get('notifications/check', 'Api\V1\TaskController@checkPendingTasks');
    Route::delete('tasks/{id}', 'Api\V1\TaskController@deleteTask');
    Route::post('notifications/mark-as-read', 'Api\V1\TaskController@markNotificationsAsRead');
    Route::post('notifications/mark-as-checked', 'Api\V1\TaskController@markNotificationAsChecked');
});
