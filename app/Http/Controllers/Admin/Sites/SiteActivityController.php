<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteActivityController extends Controller
{
    public function index($id)
    {
        $title = 'Site Activity';
        $site = Site::findOrFail($id);
        return view('admin.sites.activity', compact('title', 'site'));
    }
}
