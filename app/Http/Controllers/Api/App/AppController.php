<?php

namespace App\Http\Controllers\Api\App;

use Carbon\Carbon;
use App\Models\Patrol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


if($patrol){
    return response()->json([
        'message' => 'Patrol started successfully',
        'success' => true,
        'patrol' => $patrol,
    ], 201);
}else{
    return response()->json([
        'message' => 'Patrol not started',
        'error' =>$errors->all(),
        'success' => false,
    ], 400);
}
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
