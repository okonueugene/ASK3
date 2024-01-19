<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IssuesController extends Controller
{
    public function index()
    {
        return view('admin.issues');
    }
}
