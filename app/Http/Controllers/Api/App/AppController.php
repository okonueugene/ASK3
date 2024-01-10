<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
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
            'guard_id' => $request->guard_id,
            'site_id' => $request->site_id,
            'start' => $request->time,
            'name' => $name,
        ]);



        return response()->json([
            'message' => 'Patrol started successfully',
            'patrol' => $patrol,
        ], 201);
    }

    public function scanCheckPoints(Request $request)
    {
        $request->validate([
            'patrol_id' => 'required',
            'checkpoint_id' => 'required',
            'time' => 'required',
        ]);

        $checkpoint = Checkpoint::findOrFail($request->checkpoint_id);

        $checkpoint->update([
            'scanned' => true,
            'scanned_at' => $request->time,
        ]);

        $patrol = Patrol::findOrFail($request->patrol_id);

        $patrol->update([
            'checkpoint_id' => $request->checkpoint_id,
            'checkpoint_scanned_at' => $request->time,
        ]);

        return response()->json([
            'message' => 'Checkpoint scanned successfully',
            'checkpoint' => $checkpoint,
            'patrol' => $patrol,
        ], 201);
    }

}
