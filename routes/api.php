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

 //get all tasks for a guard
//  public function guardTasks(Request $request)
//  {
//      $tasks = auth()->guard()->user()->tasks()->with('media')->orderBy('created_at', 'DESC')->whereDate('date', Carbon::today())->get();

//      if (count($tasks) > 0) {
//          return response()->json([
//              'success' => true,
//              'message' => 'Tasks retrieved successfully',
//              'data' => $tasks,
//          ]);

//      } else {
//          return response()->json([
//              'success' => false,
//              'message' => 'No Tasks found',
//          ]);
//      }
//  }

//  public function ShowTask(Request $request, Task $task)
//  {
//      return response()->json([
//          'success' => true,
//          'data' => $task,
//      ], 200);
//  }

//  //Complete Task
//  public function completeTask(Request $request, Task $task)
//  {
//      $this->validate($request, [
//          'id' => 'required|exists:tasks,id',
//          'comments' => 'nullable|string',
//      ]);

//      $id = $request->input('id');

//      $task = Task::where('id', $id)->first();

//      if ($task) {
//          $task->update([
//              'status' => 'completed',
//              'comments' => $request->comments,
//          ]);

//          $img = $request->file;
//          $img1 = $request->file1;
//          $img2 = $request->file2;

//          if ($img != null) {
//              $filename = "IMG" . rand() . ".jpg";
//              $decoded = base64_decode($img);

//              $task->addMediaFromString($decoded)
//                  ->usingFileName($filename)
//                  ->toMediaCollection('tasks');
//          }

//          if ($img1 != null) {
//              $filename = "IMG" . rand() . ".jpg";

//              $decoded = base64_decode($img1);

//              $task->addMediaFromString($decoded)
//                  ->usingFileName($filename)
//                  ->toMediaCollection('tasks');
//          }

//          if ($img2 != null) {
//              $filename = "IMG" . rand() . ".jpg";

//              $decoded = base64_decode($img2);

//              $task->addMediaFromString($decoded)
//                  ->usingFileName($filename)
//                  ->toMediaCollection('tasks');
//          }

//          //log activity
//          activity()->causedBy($task->owner)
//              ->withProperties(['site_id' => $task->owner->site_id])
//              ->event('updated')
//              ->performedOn($task)
//              ->useLog('Task')
//              ->log($task->owner->name . ' completed task ' . $task->title);

//          return response()->json([
//              'success' => true,
//              'message' => 'Task updated succesfully',
//              'data' => $task,
//          ]);

//      } else {
//          return response()->json(['message' => 'Task not found'], 404);
//      }
//  }

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
        Route::get('/patrol/scheduled', 'scheduledGuardPatrols');
        Route::post('/patrol-history', 'singlePatrol');
        Route::post('/patrol-tags', 'tagByPatrol');
        //scanned scheduled patrols
        Route::post('/patrol/collected-tags', 'collectedTags');

        //tag routes

        Route::post('/tag/add', 'addTag');
        Route::post('/tag/site-tags', 'siteTags');
        Route::post('/dashboard-stats', 'dashboardStats');
        //incident routes
        Route::post('/incidents', 'addIncident');
        //site incidents
        Route::post('/site-incidents', 'siteIncidents');
        //single incident
        Route::post('/incidents/{id}', 'getIncident');
        //sos routes
        Route::post('/sos', 'sosAlert');

        //tasks
        Route::get('/tasks', 'guardTasks');
        Route::post('/tasks/{id}', 'ShowTask');
        Route::post('/task/complete', 'completeTask');
        Route::get('/tasks/total-tasks', 'totalTasks');

        //clock out
        Route::post('/clock-out', 'clockOut');

    });

});
