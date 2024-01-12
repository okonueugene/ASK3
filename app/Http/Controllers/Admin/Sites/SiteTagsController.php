<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteTagsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Tags';
        $site = Site::findOrFail($id);
        $tags = $site->tags;
        return view('admin.sites.tags', compact('title', 'site', 'tags'));
    }
}
