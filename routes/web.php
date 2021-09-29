<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NooController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PlanVisitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
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
##HANDLE JETSTREAM BLOCK
Route::get('/', [LoginController::class,'index']);
Route::get('/login', [LoginController::class,'index'])->name('login');

##LOGIN
Route::get('/masuk',[LoginController::class,'index'])->name('masuk');
Route::post('/masuk',[LoginController::class,'login']);

##EXPORT
Route::get('/outlet/export',[OutletController::class,'export']);

##MIDDLEWARE
Route::middleware(['auth', 'isAdmin'])->group(function () {

##DASHBOARD
Route::get('/dashboard',[DashboardController::class,'index']);
Route::get('/dashboard/logout',[DashboardController::class,'logout']);

##NOO
Route::get('/noo',[NooController::class,'index']);
Route::get('/noo/{id}',[NooController::class,'show']);

##OUTLET
Route::get('/outlet',[OutletController::class,'index']);
Route::get('/outlet/{id}',[OutletController::class,'show']);

##USER
Route::get('/user',[UserController::class,'index']);

##VISIT
Route::get('/visit',[VisitController::class,'index']);

##PLANVISIT
Route::get('/planvisit',[PlanVisitController::class,'index']);

});




