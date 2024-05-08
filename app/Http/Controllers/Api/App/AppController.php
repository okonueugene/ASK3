<?php

namespace App\Http\Controllers\Api\App;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Guard;
use App\Models\Patrol;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Models\PatrolHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function startPatrol(Request $request)
    {
        $request->validate([
            'guard_id' => 'required',
            'site_id' => 'required',
            'time' => 'required',
        ]);

        $site_patrols = Patrol::where('site_id', $request->site_id)->where('created_at', '>=', Carbon::today())->get();
        $name = 'Patrol ' . ($site_patrols->count() + 1);
        $patrol = Patrol::create([
            'company_id' => $request->user()->company_id,
            'guard_id' => $request->guard_id,
            'site_id' => $request->site_id,
            'start' => $request->time,
            'name' => $name,
        ]);
        activity()
            ->causedBy($patrol->owner)
            ->event('updated')
            ->withProperties(['patrol' => $patrol])
            ->performedOn($patrol)
            ->useLog('Patrol')
            ->log('Patrol started');

        if ($patrol) {
            return response()->json([
                'message' => 'Patrol started successfully',
                'success' => true,
                'patrol' => $patrol,
            ]);
        } else {
            return response()->json([
                'message' => 'Patrol not started',
                'error' => $errors->all(),
                'success' => false,
            ]);
        }
    }

    public function scanCheckPoints(Request $request)
    {
        //validate request
        $request->validate([
            'guard_id' => 'required',
            'site_id' => 'required',
            'patrol_id' => 'required',
            'code' => 'required',
            'time' => 'required',
            'date' => 'required',
        ]);

        //verify if tag exists and is assigned to that site
        $tag = Tag::where('code', $request->code)->first();

        if (!$tag) {
            return response()->json([
                'message' => 'Tag not found',
                'success' => false,
            ]);
        }
        $tag_site = Tag::where('code', $request->code)->where('site_id', $request->site_id)->first();

        if (!$tag_site) {
            return response()->json([
                'message' => 'Tag not assigned to this site',
                'success' => false,
            ]);
        }

        //check if tag has been scanned before
        $tag_scanned = PatrolHistory::where('tag_id', $tag_site->id)->where('patrol_id', $request->patrol_id)->first();

        if ($tag_scanned) {
            return response()->json([
                'message' => 'Tag already scanned',
                'success' => false,
            ]);
        }

        $tag_id = $tag_site->id;

        //insert record of scan to patrol_histories table

        $patrol_history = PatrolHistory::create([
            'company_id' => $request->user()->company_id,
            'guard_id' => $request->guard_id,
            'site_id' => $request->site_id,
            'patrol_id' => $request->patrol_id,
            'tag_id' => $tag_id,
            'time' => $request->time,
            'date' => $request->date,
            'status' => 'checked',
        ]);

        activity()
            ->causedBy($patrol_history->owner)
            ->event('updated')
            ->withProperties(['patrol_history' => $patrol_history])
            ->performedOn($patrol_history)
            ->useLog('PatrolHistory')
            ->log('Tag scanned');

        if ($patrol_history) {
            return response()->json([
                'message' => 'Tag scanned successfully',
                'success' => true,
                'patrol_history' => $patrol_history,
            ]);
        } else {
            return response()->json([
                'message' => 'Tag not scanned',
                'error' => $errors->all(),
                'success' => false,
            ]);
        }

    }
    public function endPatrol(Request $request)
    {
        // Validate request
        $request->validate([
            'guard_id' => 'required',
            'site_id' => 'required',
            'patrol_id' => 'required',
            'time' => 'required',
        ]);

        // Retrieve the patrol record
        $patrol = Patrol::findOrFail($request->patrol_id);

        // Update patrol record with end time
        $patrol->update([
            'end' => $request->time,
        ]);

        activity()
            ->causedBy($patrol->owner)
            ->event('updated')
            ->withProperties(['patrol' => $patrol])
            ->performedOn($patrol)
            ->useLog('Patrol')
            ->log('Patrol ended');

        return response()->json([
            'message' => 'Patrol ended successfully',
            'success' => true,
            'patrol' => $patrol,
        ]);
    }

    public function addTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'code' => 'required',
            'type' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'site_id' => 'required',
        ]);

        // Check if tag exists
        $tag = Tag::where('code', $request->code)->first();

        // If does not exist, and type is 'qr', return error
        if (!$tag && $request->type == 'qr') {
            return response()->json([
                'success' => false,
                'message' => 'Tag does not exist',
            ]);
        }

        if ($tag) {
            // If exists and request->type is 'nfc' return error
            if ($request->type == 'nfc') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tag already exists and is assigned to ' . $tag->site->name,
                ]);
            }

            // If exists and request->type is 'qr', check if site_id is null
            if ($request->type == 'qr') {
                if ($tag->site_id === null) {
                    // Update tag
                    $tag->update([
                        'company_id' => auth()->user()->company_id,
                        'name' => $request->name,
                        'location' => $request->location,
                        'code' => $request->code,
                        'type' => $request->type,
                        'lat' => $request->lat,
                        'long' => $request->long,
                        'site_id' => $request->site_id,
                    ]);

                    // Log the activity
                    activity()
                        ->causedBy(auth()->user())
                        ->event('updated')
                        ->performedOn($tag)
                        ->withProperties(['tag' => $tag])
                        ->log('Tag updated and assigned to site ' . $tag->site->name);

                    return response()->json([
                        'success' => true,
                        'message' => 'Tag updated successfully and assigned to ' . $tag->site->name,
                        'data' => $tag,
                    ]);
                } else {

                    return response()->json([
                        'success' => false,
                        'message' => 'Tag already exists and is assigned to ' . $tag->site->name,
                    ]);
                }
            }

        } else {

            // If tag does not exist, create new tag
            $tag = Tag::create([
                'company_id' => auth()->user()->company_id,
                'name' => $request->name,
                'location' => $request->location,
                'code' => $request->code,
                'type' => $request->type,
                'lat' => $request->lat,
                'long' => $request->long,
                'site_id' => $request->site_id,
            ]);

            // Log the activity
            activity()
                ->causedBy(auth()->user())
                ->event('created')
                ->performedOn($tag)
                ->withProperties(['tag' => $tag])
                ->log('Tag created and assigned to site ' . $tag->site->name);

            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully and assigned to ' . $tag->site->name,
                'data' => $tag,
            ]);

        }
    }

    //get all tags assigned to a site
    public function siteTags(Request $request)
    {
        $request->validate([
            'site_id' => 'required',
        ]);

        $tags = Tag::where('site_id', $request->site_id)->get();

        $tags->load('history');

        if (count($tags) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Tags retrieved successfully',
                'data' => $tags,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Site Tags found',
            ]);
        }
    }
    // Dashboard stats
    // public function dashboardStats()
    // {
    //     $guard = Auth::guard('guard')->user();

    //     $allpatrols = Patrol::where('guard_id', $guard->id)->get();

    //     date_default_timezone_set('Africa/Nairobi');

    //     $time = now()->toTimeString();
    //     $today = Carbon::now($guard->site->timezone)->format('Y-m-d');

    //     $totalpatrols = count($allpatrols);
    //     $passed = Patrol::select('*')
    //         ->where('guard_id', '=', $guard->id)
    //         ->where('end', '<', $time)
    //         ->get();

    //     $roundspassed = count($passed);
    //     $todaytasks = $guard->tasks->where('date', $today)->count();

    //     $time_in = $guard->attendances()->where('day', $today)->first();

    //     return response()->json([
    //         'success' => true,
    //         'totalpatrols' => count($allpatrols),
    //         'rounds_passed' => $roundspassed,
    //         'today_tasks' => $todaytasks,
    //         'time_in' => $time_in->time_in,
    //     ], 200);

    // }

    public function dashboardStats(Request $request)
    {
        //validate request
        $request->validate([
            'guard_id' => 'required',
        ]);

        $guard = Guard::where('id', $request->guard_id)->first();

        date_default_timezone_set('Africa/Nairobi');

        $time = now()->toTimeString();
        $today = Carbon::now($guard->site->timezone)->format('Y-m-d');

        //get all patrols for the guard on the current day
        $allpatrols = Patrol::where('guard_id', $guard->id)->where('created_at', '>=', Carbon::today())->where('end', '!=', null)->get();
        //get number of tags a guard is supposed to scan
        $checkpoints = $guard->site->tags->count();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard stats retrieved successfully',
            'totalpatrols' => count($allpatrols),
            'checkpoints' => $checkpoints,
        ], 200);

    }

    //Add an Incident
    public function addIncident(Request $request)
    {
        $guard = Guard::where('id', auth()->guard()->user()->id)->first(); 


        $this->validate($request, [
            'title' => 'required',
            'details' => 'required',
            'actions_taken' => 'required'
        ]);

        $time = Carbon::now($guard->site->timezone)->toDateTimeString();

        $today = Carbon::now($guard->site->timezone)->format('Y-m-d');

        $incident = Incident::create([
            'company_id' => $guard->company_id,
            'guard_id' => $guard->id,
            'site_id' => $guard->site_id,
            'incident_no' => random_int(100000, 999999),
            'title' => $request->title,
            'details' => $request->details,
            'actions_taken' => $request->actions_taken,
            'police_ref' => $request->police_ref,
            'date' => $today,
            'time' => $time,
        ]);

        $img = $request->file;
        $img1 = $request->file1;
        $img2 = $request->file2;

        if ($img != null) {
            $filename = "IMG" . rand() . ".jpg";
            $decoded = base64_decode($img);

            $incident->addMediaFromString($decoded)
                ->usingFileName($filename)
                ->toMediaCollection('incident_images');
        }

        if ($img1 != null) {
            $filename = "IMG" . rand() . ".jpg";

            $decoded = base64_decode($img1);

            $incident->addMediaFromString($decoded)
                ->usingFileName($filename)
                ->toMediaCollection('incident_images');
        }

        if ($img2 != null) {
            $filename = "IMG" . rand() . ".jpg";

            $decoded = base64_decode($img2);

            $incident->addMediaFromString($decoded)
                ->usingFileName($filename)
                ->toMediaCollection('incident_images');
        }
        // $user = $incident->company->users()->first();

        // $email = [
        //     'subject' => 'New Incident',
        //     'greeting' => 'Hi ' . $user->name . ',',
        //     'body' => $incident->owner->name . ' has added a new Incident NO: ' . $incident->incident_no,
        //     'thanks' => 'Thank you for using ASKARI',
        //     'actionText' => 'View Incident',
        //     'actionURL' => url('/app/sites/' . $incident->siteIncident->id . '/incidents'),
        // ];

        // $user->notify(new EmailNotification($email));

        activity()->causedBy($incident->owner)
            ->withProperties(['site_id' => $incident->owner->site_id])
            ->log($incident->owner->name . ' added a new Incident NO: ' . $incident->incident_no);

        return response()->json([
            'success' => true,
            'message' => 'Incident added successfully',
            'data' => $incident,
        ]);

    }

    //retrieve all incidents for a site
    public function siteIncidents(Request $request)
    {
        $request->validate([
            'site_id' => 'required',
        ]);

        $incidents = Incident::where('site_id', $request->site_id)->get();
        $incidents->load('media');

        if (count($incidents) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Incidents retrieved successfully',
                'data' => $incidents,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Incidents found',
            ]);
        }
    }
}
