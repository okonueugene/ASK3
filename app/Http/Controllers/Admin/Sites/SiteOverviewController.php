<?php

namespace App\Http\Controllers\Admin\Sites;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Task;
use App\Models\Guard;
use App\Models\Patrol;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteOverviewController extends Controller
{
    public function index($id)
    {
        $title = 'Site Overview';
        $site = Site::findOrFail($id);
        $ids = explode(',', $site->id);
        $data['greetings'] = $this->greeting();

        $today = Carbon::now()->toDateString();


        $data['guards'] = Guard::whereIn('site_id', $ids)->paginate(5);

        $data['patrols'] = Patrol::whereIn('site_id', $ids)->paginate(5);

        $data['tasks'] = Task::whereIn('site_id', $ids)->paginate(5);

        $data['incidents'] = Incident::whereIn('site_id', $ids)->paginate(5);

        $data['dobs'] = Guard::whereIn('site_id', $ids)->paginate(5);




        return view('admin.sites.overview', compact('title', 'site', 'data'));
    }

    private function greeting()
    {
        $hour = date('H');
        if ($hour >= 5 && $hour <= 11) {
            return 'Good morning';
        } elseif ($hour >= 12 && $hour <= 17) {
            return 'Good afternoon';
        } elseif ($hour >= 18 && $hour <= 23) {
            return 'Good evening';
        } else {
            return 'Welcome back, ';
        }
    }
}
