<?php

namespace App\Http\Controllers\Reports;

use App\Models\Site;
use App\Models\User;
use App\Models\Guard;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public $search = '';
    public $order = 'desc';
    public $site = '';

    public $filters = [
        'site' => '',
        'guard' => '',
        'range' => '',
    ];

    public $pages = 10;

    public function index()
    {
        $title = "Attendance Reports";

        $filters = $this->filters;
        $sites = Site::all();
        $selectedSite = '';
        $guards=Guard::all();
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $pages = $this->pages;
        $order = $this->order;

        $records = Attendance::where('company_id', auth()->user()->company_id)
            ->orderBy('created_at', $this->order)
            ->paginate($this->pages);

        // if ($user->user_type == 'client') {
        //     $layout = 'layouts.client';
        //     $site = $user->site;



        //     $records = Attendance::orderBy('created_at', $this->order)
        //         ->where('company_id', auth()->user()->company_id)
        //         ->whereHas('owner', function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%');
        //         })
        //         ->when(isset($this->filters['site']), function ($query) {
        //             return $query->where('site_id', $this->filters['site']);
        //         })
        //         ->when(isset($this->filters['guard']), function ($q) {
        //             return $q->where('guard_id', $this->filters['guard']);
        //         })
        //         ->when(isset($this->filters['range']), function ($query) {
        //             return $query->whereBetween('day', [$this->filters['range']['start'], $this->filters['range']['end']]);
        //         })
        //         ->where('site_id', $site->id)
        //         ->paginate($this->pages);
        // } elseif ($user->user_type == 'admin') {
        //     $layout = 'layouts.organization';

        //     $records = Attendance::orderBy('created_at', $this->order)
        //         ->where('company_id', auth()->user()->company_id)
        //         ->whereHas('owner', function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%');
        //         })
        //         ->when(isset($this->filters['site']), function ($query) {
        //             return $query->where('site_id', $this->filters['site']);
        //         })
        //         ->when(isset($this->filters['guard']), function ($q) {
        //             return $q->where('guard_id', $this->filters['guard']);
        //         })
        //         ->when(isset($this->filters['range']), function ($query) {
        //             return $query->whereBetween('day', [$this->filters['range']['start'], $this->filters['range']['end']]);
        //         })
        //         ->where('company_id', auth()->user()->company_id)
        //         ->paginate($this->pages);
        // } else {
        //     $layout = 'layouts.guard';

        //     $records = Attendance::orderBy('created_at', $this->order)
        //         ->where('company_id', auth()->user()->company_id)
        //         ->whereHas('owner', function ($query) {
        //             $query->where('name', 'like', '%' . $this->search . '%');
        //         })
        //         ->when(isset($this->filters['site']), function ($query) {
        //             return $query->where('site_id', $this->filters['site']);
        //         })
        //         ->when(isset($this->filters['guard']), function ($q) {
        //             return $q->where('guard_id', $this->filters['guard']);
        //         })
        //         ->when(isset($this->filters['range']), function ($query) {
        //             return $query->whereBetween('day', [$this->filters['range']['start'], $this->filters['range']['end']]);
        //         })
        //         ->where('guard_id', $user->id)
        //         ->paginate($this->pages);
        // }
        return view('reports.attendance', compact('title','order','guards','pages','filters','sites','selectedSite', 'records'));
    }
}
