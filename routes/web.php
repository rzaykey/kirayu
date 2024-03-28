<?php

use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\Myfile;
use App\Http\Controllers\MyPasswordController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UnitController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'dologin']);
});

Route::group(['middleware' => ['auth', 'checkrole:1,2,3,4,5,6']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/redirect', [RedirectController::class, 'cek']);
    Route::get('/dashboard', [SuperadminController::class, 'index']);
    Route::resource('/profile', ProfileController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/ubah/password', MyPasswordController::class);
    Route::resource('/document/arsip', ArsipController::class);
    Route::get('/document/my', [Myfile::class, 'index']);
    Route::get('/document/my/create', [Myfile::class, 'create']);
    Route::post('/document/my/', [Myfile::class, 'store']);
    Route::get('/document/my/{id}', [Myfile::class, 'Vmy']);
    Route::delete('/document/my/{id}', [Myfile::class, 'delete']);
    Route::get('/document/shared', [Myfile::class, 'shared']);
    Route::get('/document/shared/{id}', [Myfile::class, 'Vshared']);
});

Route::group(['middleware' => 'is_admin'], function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/categories', CategoriesController::class);
    Route::resource('/password', PasswordController::class);
    Route::resource('/documents', DocumentsController::class);
});

Route::fallback(function () {
    return redirect('/redirect');
});
