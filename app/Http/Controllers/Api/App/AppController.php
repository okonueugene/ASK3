<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\Incident;
use App\Models\Patrol;
use App\Models\PatrolHistory;
use App\Models\Site;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function startPatrol(Request $request)
    {
        $request->validate([
            'guard_id' => 'required',
            'site_id' => 'required',
            'time' => 'required',
            'created_at' => 'required',
        ]);

        //retrieve the site using the site_id
        $site = Site::where('id', $request->site_id)->first();
        //retrieve all patrols for the site for the current day
        $site_patrols = $site->patrols()->whereDate('created_at', Carbon::now($site->timezone)->format('Y-m-d'))->get();
        $name = 'Patrol ' . ($site_patrols->count() + 1);
        $patrol = Patrol::create([
            'company_id' => $request->user()->company_id,
            'guard_id' => $request->guard_id,
            'site_id' => $request->site_id,
            'start' => $request->time,
            'name' => $name,
            'created_at' => $request->created_at,
            'updated_at' => $request->created_at,
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
        $allpatrols = $guard->patrols()->whereDate('created_at', $today)->get();
        //get number of tags a guard is supposed to scan
        $checkpoints = $guard->site->tags->count();
        //get the guards attendance record for the day
        $clockin = $guard->attendances()->where('day', $today)->first();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard stats retrieved successfully',
            'totalpatrols' => count($allpatrols),
            'checkpoints' => $checkpoints,
            'clocked_in' => $clockin->time_in,
            'incidents' => $guard->site->incidents()->where('date', $today)->count(),
            'clocked_in_date' => $clockin->day . ' ' . $clockin->time_in,
        ], 200);

    }

    //Add an Incident
    public function addIncident(Request $request)
    {
        $guard = Guard::where('id', auth()->guard()->user()->id)->first();

        $this->validate($request, [
            'title' => 'required',
            'details' => 'required',
            'actions_taken' => 'required',
        ]);

        $time = Carbon::now($guard->site->timezone)->toDateTimeString();

        $today = Carbon::now($guard->site->timezone)->format('Y-m-d');

        $incident = Incident::create([
            'company_id' => $guard->company_id,
            'guard_id' => $guard->id,
            'site_id' => $guard->site_id,
            'incident_no' => time(),
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

        // activity()
        //     ->causedBy($patrol->owner)
        //     ->event('updated')
        //     ->withProperties(['patrol' => $patrol])
        //     ->performedOn($patrol)
        //     ->useLog('Patrol')
        //     ->log('Patrol ended');

        // activity()->causedBy($incident->owner)
        //     ->withProperties(['site_id' => $incident->owner->site_id])
        //     ->log($incident->owner->name . ' added a new Incident NO: ' . $incident->incident_no);

        activity()
            ->causedBy($incident->owner)
            ->event('created')
            ->performedOn($incident)
            ->withProperties(['incident' => $incident])
            ->useLog('Incident')
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

    //retrieve an incident
    public function getIncident(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $incident = Incident::where('id', $request->id)->first();
        $incident->load('media');

        if ($incident) {
            return response()->json([
                'success' => true,
                'message' => 'Incident retrieved successfully',
                'data' => $incident,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Incident not found',
            ]);
        }
    }

    public function startSceduledPatrol(Request $request)
    {
        $id = $request->input('id');

        $patrol = Patrol::where('id', $id)->first();

        if ($patrol && $patrol->type == 'scheduled') {
            activity()->causedBy($patrol->owner)
                ->withProperties(['site_id' => $patrol->owner->site_id])
                ->event('updated')
                ->performedOn($patrol)
                ->useLog('Patrol')
                ->log($patrol->owner->name . ' started a scheduled patrol ' . $patrol->name);

            return response()->json(['message' => "Patrol started successfully"], 200);
        } else {
            return response()->json(['message' => "Patrol not found"], 200);
        }
    }

    public function doPatrol(Request $request)
    {
        //validate request
        $rules = [
            'id' => 'required',
            'code' => 'required',
            'current_time' => 'required',
        ];

        $messages = [
            'id.required' => 'Patrol ID is required',
            'code.required' => 'Tag code is required',
            'current_time.required' => 'Current time is required',
        ];

        $this->validate($request, $rules, $messages);

        //retrieve the patrol record
        $id = $request->input('id');
        $patrol = Patrol::where('id', $id)->first();
        //if patrol is null, return error
        if (!$patrol) {
            return response()->json(['success' => true, 'message' => 'Patrol not found'], 200);
        }
        //if patrol exists, and is unscheduled patrol return error
        if ($patrol && $patrol->type == 'unscheduled') {
            return response()->json(['success' => true, 'message' => 'This is an Unscheduled patrol'], 200);
        }

        //if patrol is scheduled

        if ($patrol && $patrol->type == 'scheduled') {
            $guard = auth()->guard()->user();
            $guard->load('site');
            $today = Carbon::now($guard->site->timezone)->toDateString('Y-m-d');

            $code = $request->input('code');

            $tag = Tag::where('code', $code)->first();

            //Times
            $time = Carbon::parse($request->input('current_time'))->format('H:i:s');
            $start = Carbon::parse($patrol->start)->format('H:i:s');
            $end = Carbon::parse($patrol->end)->format('H:i:s');

            //Patrol tag ids in array
            $tags_ids = $patrol->tags->pluck('id')->toArray();

            if ($tag) {
                if ($patrol->owner->id == $guard->id) {
                    if (in_array($tag->id, $tags_ids)) {
                        if ($time < $end && $time > $start) {
                            $scanned = $patrol->history->where('date', $today)->where('patrol_id', $patrol->id)->where('tag_id', $tag->id)->first();
                            if ($scanned == null) {
                                PatrolHistory::updateOrCreate([
                                    'company_id' => $guard->company_id,
                                    'site_id' => $guard->site_id,
                                    'guard_id' => $guard->id,
                                    'patrol_id' => $patrol->id,
                                    'tag_id' => $tag->id,
                                    'date' => $today,
                                    'time' => $time,
                                    'status' => 'checked',
                                    'updated_at' => Carbon::now()->toDateTimeString(),

                                ]);

                                return response()->json(['success' => true, 'message' => "Checkpoint created and scanned successfully"], 200);

                            } else {
                                if ($scanned && $scanned->status == 'checked') {
                                    return response()->json(['success' => true, 'message' => "This checkpoint has already been scanned"], 200);
                                } elseif ($scanned && $scanned->status == 'upcoming' || $scanned->status == 'missed') {
                                    $scanned->update([
                                        'time' => $time,
                                        'status' => 'checked',
                                        'updated_at' => Carbon::now()->toDateTimeString(),

                                    ]);

                                    return response()->json(['success' => true, 'message' => "Checkpoint scanned successfully"], 200);
                                } else {
                                    PatrolHistory::updateOrCreate([
                                        'company_id' => $guard->company_id,
                                        'site_id' => $guard->site_id,
                                        'guard_id' => $guard->id,
                                        'patrol_id' => $patrol->id,
                                        'tag_id' => $tag->id,
                                        'date' => $today,
                                        'time' => $time,
                                        'status' => 'checked',
                                        'updated_at' => Carbon::now()->toDateTimeString(),
                                    ]);

                                    return response()->json(['success' => true, 'message' => "Checkpoint created and scanned successfully"], 200);
                                }
                            }
                        } else {
                            return response()->json(['success' => true, 'message' => "You do not have a round at this time"], 200);
                        }
                    } else {
                        return response()->json(['success' => true, 'message' => "This checkpoint is not assigned to this round"], 200);
                    }
                } else {
                    return response()->json(['success' => true, 'message' => "This round is not assigned to you"], 200);
                }
            } else {
                return response()->json(['success' => true, 'message' => "This tag does not exist in our database"], 200);
            }
        } else {
            return response()->json(['success' => true, 'message' => 'Patrol not found'], 200);
        }
    }

    //list scheduled site patrols
    public function scheduledGuardPatrols(Request $request)
    {
        $guard = auth()->guard()->user();

        $patrols = $guard->patrols()->where('type', 'scheduled')->get();

        if (count($patrols) > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Patrols retrieved successfully',
                'data' => $patrols,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Patrols found',
            ]);
        }
    }
    //tag by patrol id
    public function tagByPatrol(Request $request)
    {
        $id = $request->input('id');
        $patrol = Patrol::where('id', $id)->where('type', 'scheduled')->first();
        $tags = $patrol->tags;

        if ($tags) {
            return response()->json([
                'success' => true,
                'data' => $tags,
            ], 200);
        } else {
            return response()->json(['message' => "Tags not found"], 200);
        }

    }
    //Single Patrol History
    public function singlePatrol(Request $request)
    {
        $id = $request->input('id');
        $patrol = Patrol::where('id', $id)->first();
        $today = Carbon::now($patrol->site->timezone)->format('Y-m-d');

        if ($patrol) {
            $tags = $patrol->tags;

            $histories = PatrolHistory::where('date', $today)->where('patrol_id', $patrol->id)->get();
            $combined = array_replace_recursive($histories->toArray(), $tags->toArray());

            return response()->json([
                'success' => true,
                'data' => $combined,
            ], 200);
        } else {
            return response()->json(['message' => "Patrol not found"], 404);
        }

    }

    //single patrol history of checked tags
    public function collectedTags(Request $request)
    {
        $patrol = Patrol::find($request->id);

        if (!$patrol) {
            return response()->json(['success' => true, 'message' => 'Patrol not found'], 200);
        } else if ($patrol->type == 'unscheduled') {
            return response()->json(['success' => true, 'message' => 'This is an Unscheduled patrol'], 200);
        } else {
            return response()->json(['success' => true, 'message' => 'Patrol found'], 200);
        }

        $today = Carbon::now($patrol->site->timezone)->format('Y-m-d');

        if ($patrol) {
            $history = PatrolHistory::where('date', $today)->where('patrol_id', $patrol->id)->where('status', 'checked')->first();
            $history->load('tag');

            $data = array();

            //append history to data array
            $data['name'] = $history->tag->name;
            $data['location'] = $history->tag->location;
            $data['time'] = $history->time;

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        } 
    }

}
