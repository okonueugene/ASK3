<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteGuardsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Guards';
        $site = Site::findOrFail($id);
        return view('admin.sites.guards', compact('title', 'site'));
    }
}
