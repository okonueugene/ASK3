<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Guard;
use Illuminate\Http\Request;
use App\Models\PatrolHistory;
use App\Http\Controllers\Controller;

class PatrolReportsController extends Controller
{

    public $filters = [];

    public function index(Request $request)
    {

        $title = 'Patrol Reports';
        $sites = Site::where('company_id', auth()->user()->company_id)->get();
        $guards = $this->handleGuardFilter($request);

        $records = $this->fetchRecords();
        $total = count($records);

        return view('reports.patrols', compact('records', 'title', 'total', 'sites', 'guards'));
    }

    public function filterRecords(Request $request)
    {
        $this->filters = []; // Reset filters array

        if ($request->filled('site_id') && $request->input('site_id') != null) {
            $this->filters['site'] = $request->input('site_id');
        }

        if ($request->filled('guard_id') && $request->input('guard_id') != null) {
            $this->filters['guard'] = $request->input('guard_id');
        }
        if ($request->filled('start_date')) {
            // Convert start date format
            $this->filters['range']['start'] = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
        }
    
        if ($request->filled('end_date')) {
            // Convert end date format
            $this->filters['range']['end'] = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
        }
    

        $records = $this->fetchRecords();

        return response()->json(['records' => $records, 'filters' => $this->filters], 200);

    }

    private function handleGuardFilter(Request $request)
    {
        $guards = Guard::where('company_id', auth()->user()->company_id)->get();

        if ($request->filled('site_id') && $request->input('site_id') != null) {
            $guards = $guards->where('site_id', $request->input('site_id'));
        }

        return $guards;
    }

    private function fetchRecords()
    {
        return PatrolHistory::with(['patrol', 'site', 'tag', 'company', 'owner'])
            ->when(isset($this->filters['site']), function ($query) {
                return $query->where('site_id', $this->filters['site']);
            })
            ->when(isset($this->filters['guard']), function ($q) {
                return $q->where('guard_id', $this->filters['guard']);
            })
            ->when(isset($this->filters['range']), function ($query) {
                return $query->whereBetween('date', [$this->filters['range']['start'], $this->filters['range']['end']]);
            })
            ->orderBy('id', 'desc')
            ->get();
    }
}
