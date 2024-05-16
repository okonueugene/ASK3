<?php

use App\Http\Controllers\Api\App\AppController;
use App\Http\Controllers\Api\App\AuthenticationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::post('guard/login', [AuthenticationController::class, 'login']);

Route::group(['prefix' => 'guard', 'middleware' => ['auth:sanctum', 'ensure_json_header']], function () {

    Route::get('/profile', [AuthenticationController::class, 'profile']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::controller(AppController::class)->group(function () {
        //patrol routes
        Route::post('/patrol/start', 'startPatrol');
        Route::post('/patrol/scan', 'scanCheckPoints');
        Route::post('/patrol/end', 'endPatrol');
        Route::post('/patrol/start-scheduled', 'startSceduledPatrol');
        Route::post('/patrol/scan-scheduled', 'doPatrol');

        //tag routes
        Route::post('tag/add', 'addTag');
        Route::post('tag/site-tags', 'siteTags');
        Route::post('/dashboard-stats', 'dashboardStats');
        //incident routes
        Route::post('/incidents', 'addIncident');
        //site incidents
        Route::get('/site-incidents', 'siteIncidents');
        //single incident
        Route::get('/incidents/{id}', 'getIncident');
    });

});
