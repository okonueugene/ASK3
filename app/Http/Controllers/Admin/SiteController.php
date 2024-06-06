<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use App\Models\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SiteResource;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;

class SiteController extends Controller
{
    public function index()
    {
        $title = 'Sites';

        $sites = Site::orderBy('id', 'DESC')->where('company_id', auth()->user()->company_id)->get();
        //load media
        $sites->load('media');

        $countries = config('sitedata.countries');
        $timezones = config('sitedata.timezones');


        return view('admin.sites', compact('title', 'sites', 'countries', 'timezones'));
    }

    public function addSite(StoreSiteRequest $request)
    {
        try {
            \DB::beginTransaction();

            //validate request
            $request->validated();

            $site = Site::create([
                'company_id' => auth()->user()->company_id,
                'name' => $request->name,
                'location' => $request->location,
                'lat' => $request->lat,
                'long' => $request->long,
                'timezone' => $request->timezone,
                'country' => $request->country,
            ]);


            //upload media
            if ($request->hasFile('logo')) {
                $site->addMediaFromRequest('logo')->toMediaCollection('site_logo');
            }

            \DB::commit();

            activity()
                ->causedBy(auth()->user())
                ->event('created')
                ->performedOn($site)
                ->withProperties(['site'=>$site])
                ->useLog('Site')
                ->log('Site created');

            return redirect()->back()->with('success', 'Site added successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong' . $e);
        }

    }

    public function quickView($id)
    {
        $site = Site::where('id', $id)->first();
        if (!$site) {
            return response()->json([
                'message' => 'Site not found'
            ], 404);
        }
        $site->load('media', 'owner', 'guards');
        return response()->json([
            'message' => 'Site details',
            'site' => $site
        ]);
    }

    public function updateSite(UpdateSiteRequest $request, $id)
    {

        try {
            \DB::beginTransaction();

            //validate request
            $request->validated();

            $site = Site::where('id', $id)->first();
            if (!$site) {
                return response()->json([
                    'message' => 'Site not found'
                ], 404);
            }

            $site->update([
                'name' => $request->name,
                'location' => $request->location,
                'lat' => $request->lat,
                'long' => $request->long,
                'timezone' => $request->timezone,
                'country' => $request->country,
            ]);

            //upload media
            if ($request->hasFile('logo')) {
                $site->addMediaFromRequest('logo')->toMediaCollection('site_logo');
            }

            \DB::commit();

            activity()
                ->causedBy(auth()->user())
                ->event('updated')
                ->performedOn($site)
                ->withProperties(['site'=>$site])
                ->useLog('Site')
                ->log('Site updated');

            return response()->json([
                'message' => 'Site updated successfully',
                'site' => $site
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong' . $e);
        }
    }

    public function showSite($id)
    {

        $site = Site::where('id', $id)->first();
        $title = 'Details of ' . $site->name;
        $countries = config('sitedata.countries');
        $timezones = config('sitedata.timezones');


        return view('admin.site-details', compact('title', 'site', 'countries', 'timezones'));
    }

    public function deleteSite($id)
    {
        try {
            \DB::beginTransaction();

            $site = Site::where('id', $id)->first();
            if (!$site) {
                return response()->json([
                    'message' => 'Site not found'
                ], 404);
            }

            $site->delete();

            \DB::commit();

            activity()
                ->causedBy(auth()->user())
                ->event('deleted')
                ->performedOn($site)
                ->withProperties(['site'=>$site])
                ->useLog('Site')
                ->log('Site deleted');

            return redirect()->back()->with('success', 'Site deleted successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong' . $e);
        }
    }

    public function changeSiteStatus($id)
    {
        try {
            \DB::beginTransaction();

            $site = Site::where('id', $id)->first();
            if (!$site) {
                return response()->json([
                    'message' => 'Site not found'
                ], 404);
            }

            $status = $site->is_active == 1 ? 0 : 1;

            DB::table('sites')->where('id', $id)->update([
                'is_active' => $status
            ]);


            \DB::commit();

            activity()
                ->causedBy(auth()->user())
                ->event('updated')
                ->performedOn($site)
                ->withProperties(['site'=>$site])
                ->useLog('Site')
                ->log('Site status changed');

            return response()->json([
                'message' => 'Site status changed successfully',
                'site' => $status
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'message' => 'Something went wrong' . $e
            ], 500);
        }
    }
}
