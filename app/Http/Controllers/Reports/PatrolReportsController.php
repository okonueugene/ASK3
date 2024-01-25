<?php

namespace App\Http\Controllers\Reports;

use App\Exports\PatrolReportsExport;
use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\PatrolHistory;
use App\Models\Site;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatrolReportsController extends Controller
{

    public $filters = [];

    public function index(Request $request)
    {

        $title = 'Patrol Reports';
        $sites = Site::where('company_id', auth()->user()->company_id)->get();
        $guards = Guard::where('company_id', auth()->user()->company_id)->get();

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
            $this->filters['range']['start'] = Carbon::createFromFormat('m/d/Y', $request->input('start_date'))->format('Y-m-d');
        }

        if ($request->filled('end_date')) {
            // Convert end date format
            $this->filters['range']['end'] = Carbon::createFromFormat('m/d/Y', $request->input('end_date'))->format('Y-m-d');
        }

        $records = $this->fetchRecords();

        return response()->json(['records' => $records, 'filters' => $this->filters], 200);

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

    public function export(Request $request)
    {

        $request->validate([
            'site_id' => 'required',
        ]);

        $date = Carbon::now()->format('d-m-Y');

        $filters = [];

        if ($request->filled('site_id') && $request->input('site_id') != null) {
            $filters['site'] = $request->input('site_id');
        }

        if ($request->filled('guard_id') && $request->input('guard_id') != null) {
            $filters['guard'] = $request->input('guard_id');
        }
        if ($request->filled('start_date')) {
            // Convert start date format
            $filters['range']['start'] = Carbon::createFromFormat('m/d/Y', $request->input('start_date'))->format('Y-m-d');
        }

        if ($request->filled('end_date')) {
            // Convert end date format
            $filters['range']['end'] = Carbon::createFromFormat('m/d/Y', $request->input('end_date'))->format('Y-m-d');
        }

        $site = Site::findOrFail($request->input('site_id'));

        $file = 'Patrol Report ' . $date . '.' . $request->input('ext');

        activity()
            ->causedBy(auth()->user())
            ->event('generated')
            ->performedOn($request->user())
            ->useLog('Patrol Report')
            ->log('Generated an ' . strtoupper($request->input('ext')) . ' For ' . $site->name);

        return \Excel::download(new PatrolReportsExport($filters), $file);
    }

    public function generatePdfReport(Request $request)
    {
        //validate the request
        $request->validate([
            'site_id' => 'required',
        ]);

        $this->filters = []; // Reset filters array

        if ($request->filled('site_id') && $request->input('site_id') != null) {
            $this->filters['site'] = $request->input('site_id');
        }

        if ($request->filled('guard_id') && $request->input('guard_id') != null) {
            $this->filters['guard'] = $request->input('guard_id');
        }
        if ($request->filled('start_date')) {
            // Convert start date format
            $this->filters['range']['start'] = Carbon::createFromFormat('m/d/Y', $request->input('start_date'))->format('Y-m-d');
        }

        if ($request->filled('end_date')) {
            // Convert end date format
            $this->filters['range']['end'] = Carbon::createFromFormat('m/d/Y', $request->input('end_date'))->format('Y-m-d');
        }
        $site = Site::findOrFail($request->input('site_id'));

        $records = $this->fetchRecords();

        $pdfContent = PDF::loadView('exports.patrol_report', compact('records', 'site'))->output();

        activity()
            ->performedOn($site)
            ->event('generated')
            ->causedBy(auth()->user())
            ->useLog('Attendance Report')
            ->log('Generated a PDF Attendance report for ' . $site->name);

        return response()->streamDownload(
            fn() => print($pdfContent),
            $site->name . ' Patrol Report ' . date('d-m-Y') . '.pdf'
        );

    }
}
