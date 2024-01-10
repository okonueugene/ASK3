<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteStatisticsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Statistics';
        $site = Site::findOrFail($id);
        return view('admin.sites.statistics', compact('title', 'site'));
    }
}
