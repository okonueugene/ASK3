<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\App\AppController;
use App\Http\Controllers\Api\App\AuthenticationController;

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

Route::group(['prefix' => 'guard', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', [AuthenticationController::class, 'profile']);
    Route::post('/auth/logout', [AuthenticationController::class, 'logout']);
    Route::controller(AppController::class)->group(function () {
        Route::get('/patrol/start', 'startPatrol');
     
    });





/*
|--------------------------------------------------------------------------
| AUTH Routes - CONFIG TOOL
|--------------------------------------------------------------------------
|
| ROUTES FOR CONFIG APPLICATION
|
// */
// Route::post('auth/tool/login', [ToolAuthController::class, 'login']);

// Route::group([
//     'prefix' => 'tool',
//     'middleware' => 'auth:tool'
// ], function () {
//     Route::post('/auth/logout', [ToolAuthController::class, 'logout']);

//     Route::controller(ConfigToolController::class)->group(function () {
//         Route::get('/sites', 'sites');
//         Route::get('/tags', 'allTags');
//         Route::post('/tags/site', 'getSiteTags');
//         Route::post('tag/create', 'createTag');
//         Route::post('tag/update', 'updateTag');
//     });
// });


/*
|--------------------------------------------------------------------------
| ROUTES - CLIENT APP
|--------------------------------------------------------------------------
|
| ROUTES FOR CLIENT APPLICATION
|
*/
// Route::post('auth/client/login', [ClientAuthController::class, 'login']);
// Route::group([
//     'prefix' => 'client',
//     'middleware' => 'auth:tool'
// ], function () {
//     Route::post('/auth/logout', [ClientAuthController::class, 'logout']);

//     Route::controller(ClientAppController::class)->group(function () {
//         Route::get('/dashboard', 'dashboardStats');
//     });
// });

});

