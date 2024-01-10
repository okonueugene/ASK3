<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitePatrolsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Patrols';
        $site = Site::findOrFail($id);
        return view('admin.sites.patrols', compact('title', 'site'));
    }
}
