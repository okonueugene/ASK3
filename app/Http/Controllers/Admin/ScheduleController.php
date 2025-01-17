<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $title = 'Scheduler';
        $events = [];
        return view('admin.scheduler', compact('title', 'events'));
    }
}
