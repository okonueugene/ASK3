<?php

namespace App\Http\Controllers\Admin;

use App\Models\Incident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class IncidentsController extends Controller
{
    public function index()
    {
        $title = "Incidents";
        $incidents = Incident::all();
        return view('admin.incidents', compact('title', 'incidents'));
    }
}
