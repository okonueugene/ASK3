<?php

namespace App\Http\Controllers\Reports;

use App\Exports\AttendanceReportsExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Guard;
use App\Models\Site;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public $filters = [];

    public function index()
    {
        $title = "Attendance Reports";

        $sites = Site::where('company_id', auth()->user()->company_id)->get();

        $guards = Guard::where('company_id', auth()->user()->company_id)->get();

        $records = $this->fetchRecords();

        $total = count($records);

        return view('reports.attendance', compact('title', 'records', 'total', 'sites', 'guards'));
    }

    private function fetchRecords()
    {
        return Attendance::with(['owner', 'site'])
            ->orderBy('created_at', 'DESC')
            ->where('company_id', auth()->user()->company_id)
            ->when(isset($this->filters['site']), function ($query) {
                return $query->where('site_id', $this->filters['site']);
            })
            ->when(isset($this->filters['guard']), function ($query) {
                return $query->where('guard_id', $this->filters['guard']);
            })
            ->when(isset($this->filters['range']), function ($query) {
                return $query->whereBetween('day', [$this->filters['range']['start'], $this->filters['range']['end']]);
            })->get();

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

    public function export(Request $request)
    {
        //validate the request
        $request->validate([
            'site_id' => 'required',
        ]);

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

        $date = Carbon::now()->format('d-m-Y');

        if ($request->filled('site_id')) {
            $site = Site::findOrFail($request->input('site_id'));

            $file = $site->name . ' Attendance Report ' . $date . '.' . $request->input('ext');
        } else if ($request->filled('guard_id')) {
            $guard = Guard::findOrFail($request->input('guard_id'));

            $file = $guard->name . ' Attendance Report ' . $date . '.' . $request->input('ext');
        } else {
            $file = 'Attendance Report ' . $date . '.' . $request->input('ext');
        }

        activity()
            ->performedOn($site)
            ->event('generated')
            ->causedBy(auth()->user())
            ->useLog('Attendance Report')
            ->log('Generated an Excel attendance report for ' . $site->name);

        return Excel::download(new AttendanceReportsExport($filters), $file);
    }

    public function generatePdfReport(Request $request)
    {

        //validate the request
        $request->validate([
            'site_id' => 'required',
        ]);

        $this->filters = [];
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

        $site = Site::findOrFail($request->input('site_id'));

        $timestamp = Carbon::now()->timestamp;

        // Get the site name
        $siteName = $site->name;

        // Get the guard's name if a specific guard is selected

        $guardName = $request->filled('guard_id') ? Guard::findOrFail($request->input('guard_id'))->name : 'All Guards';

        // Determine the report title based on the date range
        if (!isset($this->filters['range']) || count($this->filters['range']) == 0) {
            $reportTitle = 'All Time';
        } else {
            if (Carbon::parse($this->filters['range']['start'])->diffInDays(Carbon::parse($this->filters['range']['end'])) == 7) {
                $reportTitle = 'Weekly';
            } elseif (Carbon::parse($this->filters['range']['start'])->diffInDays(Carbon::parse($this->filters['range']['end'])) == 30) {
                $reportTitle = 'Monthly';
            } elseif (Carbon::parse($this->filters['range']['start'])->diffInDays(Carbon::parse($this->filters['range']['end'])) == 1) {
                $reportTitle = 'Daily';
            } else {
                $reportTitle = 'Custom';
            }
        }

        // Append the site name and guard's name (if available) to the report title
        $reportTitle .= ' Guard Attendance Report';
        $reportTitle .= $siteName ? ' - ' . $siteName : '';
        $reportTitle .= $guardName ? ' - ' . $guardName : '';

        $pdf = Pdf::loadView('exports.attendance_report', compact('records', 'reportTitle', 'timestamp', 'site'));
        //log the user activity
        activity()
            ->performedOn($site)
            ->event('generated')
            ->causedBy(auth()->user())
            ->useLog('Attendance Report')
            ->log('Generated a PDF attendance report for ' . $site->name);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $site->name . ' Attendance Report ' . date('d-m-Y') . '.pdf'
        );
    }
}
