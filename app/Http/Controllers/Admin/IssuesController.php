<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssuesController extends Controller
{
    public function index()
    {
        $title = "Issues";
        $issues = Issue::all();
        return view('admin.issues', compact('title', 'issues'));
    }
}
