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

        // Validate the request
        $request->validate([
            'site_id' => 'required',
        ]);

        $this->filters = [];

        // Reset filters array
        if ($request->filled('site_id') && $request->input('site_id') != null) {
            $this->filters['site'] = $request->input('site_id');
        }

        if ($request->filled('guard_id') && $request->input('guard_id') != null) {
            $this->filters['guard'] = $request->input('guard_id');
        }

        if ($request->filled('start_date')) {
            $this->filters['range']['start'] = Carbon::createFromFormat('m/d/Y', $request->input('start_date'))->format('Y-m-d');
        }

        if ($request->filled('end_date')) {
            $this->filters['range']['end'] = Carbon::createFromFormat('m/d/Y', $request->input('end_date'))->format('Y-m-d');
        }

        $records = $this->fetchRecords();

        $site = Site::findOrFail($request->input('site_id'));

        $currentTimestamp = Carbon::now()->timestamp;

        $reportTitle = $this->determineReportTitle();

        $siteName = $site->name;
        $guardName = $request->filled('guard_id') ? Guard::findOrFail($request->input('guard_id'))->name : 'All Guards';

        $reportTitle .= ($siteName ? ' - ' . $siteName : '') . ($guardName ? ' - ' . $guardName : '');

        $pdf = Pdf::loadView('exports.attendance_report', compact('records', 'reportTitle', 'currentTimestamp', 'site'));

        // Log the user activity
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

    private function determineReportTitle(): string
    {
        if (!isset($this->filters['range']) || count($this->filters['range']) == 0) {
            return 'All Time Report';
        }

        $daysDifference = Carbon::parse($this->filters['range']['start'])->diffInDays(Carbon::parse($this->filters['range']['end']));

        switch ($daysDifference) {
            case 7:
                return 'Weekly Report';
            case 30:
                return 'Monthly Report';
            case 1:
                return 'Daily Report';
            case 0:
                return "Today's Report";
            default:
                return 'Custom';
        }
    }
}
