<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Models\Site;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteIncidentsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Incidents';
        $site = Site::findOrFail($id);
        $incidents = $site->incidents()->orderBy('id', 'DESC')->get();
        $incidents->load('owner', 'media');
        return view('admin.sites.incidents', compact('title', 'site', 'incidents'));
    }


    public function update(Request $request, $id)
    {

        $police_ref = $request->edit_police_ref;

        if($police_ref === 'N/A') {
          //set police ref to null
            $police_ref = null; 
        }

        $incident = Incident::where('id', $id)->update([
            'status' => $request->edit_status,
            'police_ref' => $police_ref,
        ]);

        if($incident) {
            return redirect()->back()->with('success', 'Incident updated successfully');
        }
        else {
            return redirect()->back()->with('error', 'Incident not updated');
        }
    }

    public function destroy($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->delete();
        return redirect()->back()->with('success', 'Incident deleted successfully');
    }
}
