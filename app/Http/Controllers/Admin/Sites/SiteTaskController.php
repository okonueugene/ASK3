<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\Site;
use App\Models\Task;
use Illuminate\Http\Request;

class SiteTaskController extends Controller
{
    public function index($id)
    {
        $title = 'Site Task';

        $site = Site::findOrFail($id);

        $tasks = $site->tasks->sortByDesc('id')->load('site', 'owner');

        $siteguards = $site->guards;

        return view('admin.sites.task', compact('title', 'site', 'tasks', 'siteguards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guard_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $guard = Guard::findOrFail($request->guard_id);


        $task = new Task();

        $task->company_id = $guard->company_id;
        $task->guard_id = $request->guard_id;
        $task->site_id = $request->site_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->comments = $request->comments;
        $task->from = $request->from;
        $task->to = $request->to;
        $task->status = 'pending';

        $task->save();

        //log activity
        activity()
            ->performedOn($task)
            ->causedBy(auth()->user())
            ->withProperties(['guard_id' => $request->guard_id])
            ->log('Task created');

        return redirect()->back()->with('success', 'Task added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guard_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        $task = Task::findOrFail($id);

       $task->update([
            'guard_id' => $request->guard_id,
            'title' => $request->title,
            'description' => $request->description,
            'comments' => $request->comments,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
        ]);

        //log activity
        activity()
            ->performedOn($task)
            ->causedBy(auth()->user())
            ->withProperties(['guard_id' => $request->guard_id])
            ->log('Task updated');

        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        //log activity
        activity()
            ->performedOn($task)
            ->causedBy(auth()->user())
            ->withProperties(['guard_id' => $task->guard_id])
            ->log('Task deleted');

        return redirect()->back()->with('success', 'Task deleted successfully');
    }

    public function deleteMultipleTasks(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:tasks,id',
        ]);

        $ids = $request->ids;

        $tasks = Task::whereIn('id', $ids)->get();

        foreach ($tasks as $task) {
            $task->delete();

            activity()
                ->event('delete')
                ->performedOn($task)
                ->causedBy(auth()->user())
                ->log('Task deleted');
        }

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully',
        ]);
    }
}
