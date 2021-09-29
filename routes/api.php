<?php

use App\Helpers\SendNotif;
use App\Http\Controllers\API\NooController;
use App\Http\Controllers\API\OutletController;
use App\Http\Controllers\API\PlanVisitController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VisitController;
use App\Models\User;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
//USER
Route::get('user',[UserController::class,'fetch']);
Route::post('logout',[UserController::class,'logout']);

//OUTLET
Route::get('outlet', [OutletController::class,'fetch']);
Route::get('outlet/{nama}', [OutletController::class,'singleOutlet']);


//VISIT
Route::get('visit',[VisitController::class,'fetch']);
Route::get('visit/check',[VisitController::class,'check']);
Route::post('visit',[VisitController::class,'submit']);

//PLANVISIT
Route::get('planvisit',[PlanVisitController::class,'fetch']);
Route::post('planvisit',[PlanVisitController::class,'add']);
Route::get('planvisit/filter',[PlanVisitController::class,'bymonth']);
Route::delete('planvisit',[PlanVisitController::class,'delete']);

//NOO
Route::post('noo',[NooController::class,'submit']);
Route::get('noo/all',[NooController::class,'all']);
Route::get('noo',[NooController::class,'fetch']);

Route::post('noo/confirm',[NooController::class,'confirm']);
Route::post('noo/reject',[NooController::class,'reject']);
});

Route::post('user/register',[UserController::class,'register']);
Route::post('user/login',[UserController::class,'login']);

Route::post('notif', [SendNotif::class,'sendMessage']);


Route::get('tes', function (Request $request) {
    return '';
});
