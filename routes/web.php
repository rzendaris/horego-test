<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CMS\OrganizationController;
use App\Http\Controllers\CMS\PersonController;
use App\Http\Controllers\CMS\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::middleware(['auth'])->group(function () {
    /*------------------------------------------
    --------------------------------------------
    All Role Routes List
    --------------------------------------------
    --------------------------------------------*/
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization-view');
    Route::get('/organization/detail/{id}', [OrganizationController::class, 'fetchById'])->name('organization-detail');
    Route::post('/organization/update', [OrganizationController::class, 'update'])->name('organization-update');
    Route::post('/organization/delete', [OrganizationController::class, 'delete'])->name('organization-delete');

    Route::post('/person/create', [PersonController::class, 'create'])->name('person-create');
    Route::post('/person/update', [PersonController::class, 'update'])->name('person-update');
    Route::post('/person/delete', [PersonController::class, 'delete'])->name('person-delete');

    Route::middleware(['admin'])->group(function () {
        Route::post('/organization/create', [OrganizationController::class, 'create'])->name('organization-create');

        Route::get('/user', [UserController::class, 'index'])->name('user-view');
        Route::post('/user/create', [UserController::class, 'create'])->name('user-create');
        Route::post('/user/update', [UserController::class, 'update'])->name('user-update');
        Route::post('/user/delete', [UserController::class, 'delete'])->name('user-delete');
    });
});