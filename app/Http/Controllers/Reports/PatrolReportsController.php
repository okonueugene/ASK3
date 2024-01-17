<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\Patrol;
use App\Models\PatrolHistory;
use App\Models\Site;
use Illuminate\Http\Request;

class PatrolReportsController extends Controller
{
    
    public function index()
    {
        $title = 'Patrol Reports';
        $user = auth()->user();

        $sites = [];
        $guards = [];

        $selectedSite = null;

        if ($user->user_type == 'admin') {
            $sites = Site::select('name', 'id')->where('company_id', $user->company_id)->get();
        }

        if ($user->user_type == 'client' || !is_null($selectedSite)) {
            $guards = Guard::where('site_id', $user->site_id)->get();
        }

        $records = PatrolHistory::where('company_id', $user->company_id)->orderBy('id', 'DESC')->get();
        $total = count($records);

        return view('reports.patrols', compact('records', 'title', 'total', 'sites', 'guards'));
    }

}
