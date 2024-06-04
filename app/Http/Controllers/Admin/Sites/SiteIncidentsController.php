<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\Site;
use Illuminate\Http\Request;

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

        if ($police_ref === 'N/A') {
            //set police ref to null
            $police_ref = null;
        }

        $incident = Incident::where('id', $id)->update([
            'status' => $request->edit_status,
            'police_ref' => $police_ref,
        ]);

        if ($incident) {
            //log activity
            activity()
                ->event('update')
                ->performedOn(Incident::findOrFail($id))
                ->causedBy(auth()->user())
                ->log('Incident updated');

            return redirect()->back()->with('success', 'Incident updated successfully');
        } else {
            return redirect()->back()->with('error', 'Incident not updated');
        }
    }

    public function destroy($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->delete();
        //log activity
        activity()
            ->event('delete')
            ->performedOn($incident)
            ->causedBy(auth()->user())
            ->log('Incident deleted');
            
        return redirect()->back()->with('success', 'Incident deleted successfully');
    }

    public function deleteMultipleIncidents(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:incidents,id',
        ]);

        $ids = $request->ids;

        $incidents = Incident::whereIn('id', $ids)->get();

        foreach ($incidents as $incident) {
            $incident->delete();

            activity()
                ->event('delete')
                ->performedOn($incident)
                ->causedBy(auth()->user())
                ->log('Incident deleted');
        }

        return response()->json([
            'success' => true,
            'message' => 'Incident deleted successfully',
        ]);
    }
}
