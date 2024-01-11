<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Patrol;
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

        if ($patrol) {
            return response()->json([
                'message' => 'Patrol started successfully',
                'success' => true,
                'patrol' => $patrol,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Patrol not started',
                'error' => $errors->all(),
                'success' => false,
            ], 400);
        }
    }

    public function scanCheckPoints(Request $request)
    {
//verify if tag exists and is assigned to that site

//if tag is indeed assigned to that site pick the id

//insert record of scan to patrol_histories table

//return a response with the checkpoint name and the time scanned

    }

}
