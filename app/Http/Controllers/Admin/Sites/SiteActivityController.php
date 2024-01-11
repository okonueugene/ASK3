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
       //fetch all activities by model
        $activities = Activity::all();
        //filter by site_id in the properties part of the activity
      // Filter by site_id in the properties part of the activity
      $activities = $activities->filter(function ($activity) use ($site) {
        $properties = $activity->properties['attributes'] ?? null;

        // Check if 'site_id' exists in properties and matches the site's ID
        return isset($properties['site_id']) && $properties['site_id'] == $site->id;
    });
        return view('admin.sites.activity', compact('title', 'site', 'activities'));
    }
}
