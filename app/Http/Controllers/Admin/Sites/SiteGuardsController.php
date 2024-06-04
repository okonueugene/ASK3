<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use App\Models\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SiteGuardsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Guards';
        $site = Site::findOrFail($id);
        $guards = $site->guards()->get();
        return view('admin.sites.guards', compact('title', 'site', 'guards'));
    }

    public function disassociateSelectedGuards(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:guards,id',
        ]);

        $ids = $request->ids;

        $guards = Guard::whereIn('id', $ids)->get();

        foreach ($guards as $guard) {
            $guard->site_id = null;
            $guard->save();

            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->event('Disassociate')
                ->performedOn($guard)
                ->useLog('Guard')
                ->log('disassociated guard');
        }


        return response()->json([
            'status' => 200,
        ]);
    }

}
