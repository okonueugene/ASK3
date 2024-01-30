<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Guard;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    public function index()
    {

        $site = Site::where('company_id', Auth::user()->company->id)->get();

        $coordinates = Site::where('company_id', Auth::user()->company->id)->whereNotNull('lat')->whereNotNull('long')->get();

        $guards = Guard::where('company_id', Auth::user()->company->id)->get();

        $present = Attendance::where('company_id', Auth::user()->company->id)->whereDate('created_at', Carbon::today())->get();
        
        $activities = Activity::whereDate('created_at', Carbon::today())->take(4)->get();

        return view('admin.dashboard', compact('site', 'guards', 'present', 'coordinates', 'activities'));
    }
}
