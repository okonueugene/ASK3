<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class SiteActivityController extends Controller
{
    public function index($id)
    {
        $title = 'Site Activity';
        $site = Site::findOrFail($id);
        $activities = Activity::all();
        return view('admin.sites.activity', compact('title', 'site', 'activities'));
    }
}
