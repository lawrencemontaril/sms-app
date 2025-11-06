<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\SupplyRequestController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::post('/notifications/{notification}/read', function ($notificationId) {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect($notification->data['link'] ?? '/');
    })->name('notifications.read');

    /*
    | ------
    |  Home
    | ------
    */
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    /*
    | -------
    |  Users
    | -------
    */
    Route::prefix('users')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('', 'index')->name('users.index');
            Route::get('create', 'create')->name('users.create');
            Route::get('{user}/edit', 'edit')->name('users.edit');
            Route::post('', 'store')->name('users.store');
            Route::patch('{user}', 'update')->name('users.update');
        });

    /*
    | -------------
    |  Departments
    | -------------
    */
    Route::prefix('departments')
        ->controller(DepartmentController::class)
        ->group(function () {
            Route::get('', 'index')->name('departments.index');
            Route::get('{department}/edit', 'edit')->name('departments.edit');
            Route::patch('{department}', 'update')->name('departments.update');
            Route::get('create', 'create')->name('departments.create');
            Route::post('', 'store')->name('departments.store');
        });

    /*
    | ----------
    |  Supplies
    | ----------
    */
    Route::prefix('supplies')
        ->controller(SupplyController::class)
        ->group(function () {
            Route::get('', 'index')->name('supplies.index');
            Route::get('search', 'search')->name('supplies.search');
            Route::post('', 'store')->name('supplies.store');
            Route::get('{supply}/edit', 'edit')->name('supplies.edit');
            Route::patch('{supply}', 'update')->name('supplies.update');
            Route::get('create', 'create')->name('supplies.create');
        });

    /*
    | -----------------
    |  Supply Requests
    | -----------------
    */
    Route::prefix('supply-requests')
        ->controller(SupplyRequestController::class)
        ->group(function () {
            Route::get('', 'index')->name('supply-requests.index');
            Route::get('create', 'create')->name('supply-requests.create');
            Route::get('{supplyRequest}', 'show')->name('supply-requests.show');
            Route::post('', 'store')->name('supply-requests.store');
            Route::patch('{supplyRequest}', 'update')->name('supply-requests.update');
            Route::patch('{supplyRequest}/approve', 'approve')->name('supply-requests.approve');
            Route::patch('{supplyRequest}/reject', 'reject')->name('supply-requests.reject');
        });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
