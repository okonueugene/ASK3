<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use App\Models\Patrol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitePatrolsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Patrols';
        $site = Site::findOrFail($id);
        $patrols = Patrol::where('site_id', $id)->orderBy('id', 'DESC')->get()->load('owner', 'site');

        return view('admin.sites.patrols', compact('title', 'patrols', 'site'));
    }
}
