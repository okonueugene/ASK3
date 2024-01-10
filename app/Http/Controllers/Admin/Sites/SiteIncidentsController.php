<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteIncidentsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Incidents';
        $site = Site::findOrFail($id);
        return view('admin.sites.incidents', compact('title', 'site'));
    }
}
