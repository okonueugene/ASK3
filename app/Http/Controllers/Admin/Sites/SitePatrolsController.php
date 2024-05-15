<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Patrol;
use App\Models\Site;
use Illuminate\Http\Request;

class SitePatrolsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Patrols';
        $site = Site::findOrFail($id);
        $patrols = $site->patrols()->orderBy('id', 'DESC')->get();
        $siteguards = $site->guards()->orderBy('id', 'DESC')->get();
        $sitetags = $site->tags()->orderBy('id', 'DESC')->get();
        $guard = null;

        return view('admin.sites.patrols', compact('title', 'patrols', 'site', 'siteguards', 'sitetags', 'guard'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50|string',
            'start' => 'required',
            'end' => 'required',
        ]);

        Patrol::create([
            'company_id' => auth()->user()->company_id,
            'site_id' => $request->site_id,
            'guard_id' => $request->guard_id,
            'name' => $request->name,
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Patrol created successfully');
    }

    public function edit(Request $request, $id)
    {
        $patrol = Patrol::findOrFail($id);

        $patrol->update([
            'name' => $request->name,
            'start' => $request->start,
            'end' => $request->end,
        ]);

        return redirect()->back()->with('success', 'Patrol updated successfully');
    }
}
