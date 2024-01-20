<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Patrol;
use App\Models\PatrolHistory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        }}
}
