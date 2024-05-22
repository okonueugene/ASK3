<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\Site;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SiteActivityController extends Controller
{
    public function index($id)
    {
        $title = 'Site Activity';
        $site= Site::where('id', $id)->first();
        $site->load('guards');
        $siteguards = Guard::where('site_id', $id)->pluck('id');
        

        $activities = Activity::whereIn('subject_id', $siteguards)
        ->orWhereIn('causer_id', $siteguards)
        ->with('causer', 'subject')
        ->orderBy('id', 'DESC')->get();

        return view('admin.sites.activity', compact('title', 'site', 'activities'));
    }
}
