<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GuardsController;
use App\Http\Controllers\Admin\IssuesController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IncidentsController;
use App\Http\Controllers\Auth\LoginActivityController;
use App\Http\Controllers\Reports\AttendanceController;
use App\Http\Controllers\Admin\Sites\OverviewController;
use App\Http\Controllers\Admin\Sites\SiteTagsController;
use App\Http\Controllers\Reports\PatrolReportsController;
use App\Http\Controllers\Admin\Sites\SiteGuardsController;
use App\Http\Controllers\Admin\Sites\SitePatrolsController;
use App\Http\Controllers\Admin\Sites\SiteActivityController;
use App\Http\Controllers\Admin\Sites\SiteOverviewController;
use App\Http\Controllers\Admin\Sites\SiteIncidentsController;
use App\Http\Controllers\Admin\Sites\SiteStatisticsController;



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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login', [LoginController::class, 'login'])->name('loginUser');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/client/invitation', [ClientController::class, 'acceptInvite'])->name('accept-invitation');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/login-activity', [LoginActivityController::class, 'index'])->name('login-activity');
    Route::group(['prefix' => 'admin', 'middleware' => 'admin' , 'as' => 'admin.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/clients' , [ClientController::class, 'index'])->name('clients'); 
        Route::post('/clients' , [ClientController::class, 'store'])->name('addClient');
        Route::get('/clients/{id}' , [ClientController::class, 'edit'])->name('getClient');
        Route::patch('/clients/{id}' , [ClientController::class, 'update'])->name('updateClient');
        Route::delete('/clients/{id}' , [ClientController::class, 'delete'])->name('deleteClient');
        Route::put('/clients/{id}' , [ClientController::class, 'changeClientStatus'])->name('changeClientStatus');
        Route::put('/clients/site/{id}' , [ClientController::class, 'disassociateSiteFromClient'])->name('disassociateSiteFromClient');
        Route::patch('/client/site/{id}' , [ClientController::class, 'assignSiteToClient'])->name('assignSiteToClient');



        Route::get('/sites', [SiteController::class, 'index'])->name('sites');
        Route::post('/sites', [SiteController::class, 'addSite'])->name('addSite');
        Route::get('/site/{id}', [SiteController::class, 'quickView'])->name('quickView');
        Route::get('sites/{id}', [SiteController::class, 'showSite'])->name('showSite');
        Route::post('sites/{id}', [SiteController::class, 'updateSite'])->name('updateSite');
        Route::delete('sites/{id}', [SiteController::class, 'deleteSite'])->name('deleteSite');
        Route::patch('sites/status/{id}', [SiteController::class, 'changeSiteStatus'])->name('changeSiteStatus');
        Route::get('/site/site-overview/{id}', [SiteOverviewController::class, 'index'])->name('site-overview');
        Route::get('/site/site-activity/{id}', [SiteActivityController::class, 'index'])->name('site-activity');
        Route::get('/site/site-guards/{id}', [SiteGuardsController::class, 'index'])->name('site-guards');
        Route::get('/site/{id}/site-statistics', [SiteStatisticsController::class, 'index'])->name('site-statistics');
        Route::get('/site/site-tags/{id}', [SiteTagsController::class, 'index'])->name('site-tags');
        Route::get('/site/{id}/site-patrols', [SitePatrolsController::class, 'index'])->name('site-patrols');
        Route::get('/site/{id}/site-incidents', [SiteIncidentsController::class, 'index'])->name('site-incidents');


        Route::get('/guards', [GuardsController::class, 'index'])->name('guards');
        Route::post('/guards', [GuardsController::class, 'addGuard'])->name('addGuard');
        Route::get('/guards/{id}', [GuardsController::class, 'editGuard'])->name('editGuard');
        Route::patch('/guards/{id}', [GuardsController::class, 'updateGuard'])->name('updateGuard');
        Route::delete('/guards/{id}', [GuardsController::class, 'deleteGuard'])->name('deleteGuard');
        Route::post('/guards/status/{id}', [GuardsController::class, 'changeGuardStatus'])->name('changeGuardStatus');
        Route::put('/guards/site/{id}', [GuardsController::class, 'disassociateGuard'])->name('disassociateGuard');
        Route::patch('/guard/password/{id}', [GuardsController::class, 'updatePassword'])->name('updateGuardPassword');
        Route::post('/guards/assign', [GuardsController::class, 'assignGuardToSite'])->name('assignGuardToSite');
        Route::post('/site/{id}/guards', [GuardsController::class, 'getSiteGuards'])->name('getSiteGuards');

        //incidents
        Route::get('/incidents', [IncidentsController::class, 'index'])->name('incidents');
        Route::post('/incidents', [IncidentsController::class, 'addIncident'])->name('addIncident');

        //issues
        Route::get('/issues', [IssuesController::class, 'index'])->name('issues');

        Route::get('/patrol-reports', [PatrolReportsController::class, 'index'])->name('patrol-reports');
        Route::post('/patrol-reports', [PatrolReportsController::class, 'filterRecords'])->name('filterRecords');
        Route::get('/patrol-reports/export', [PatrolReportsController::class, 'export'])->name('exportRecords');
        Route::get('/patrol-reports/export/pdf', [PatrolReportsController::class, 'generatePdfReport'])->name('exportPDF');

        //scheduler
        Route::get('/scheduler', [ScheduleController::class, 'index'])->name('scheduler');


        Route::get('/attendance-reports', [AttendanceController::class, 'index'])->name('attendance-reports');
    });

    Route::group(['prefix' => 'client', 'middleware' => 'client' , 'as' => 'client.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::group(['prefix' => 'super-admin', 'middleware' => 'super-admin' , 'as' => 'super-admin.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    //invitations
    Route::post('/client/invitation', [ClientController::class, 'inviteClient'])->name('client-invitation');
    Route::post('/client/invitation/register', [ClientController::class, 'registerClient'])->name('register-client');
    Route::delete('/client/invitation/{id}', [ClientController::class, 'deleteInvitation'])->name('delete-invitation');

});
