<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Patrol;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitePatrolsController extends Controller
{
    public function index($id)
    {
        $title = 'Site Patrols';
        $site = Site::findOrFail($id);
        $patrols = $site->patrols()->orderBy('id', 'DESC')->get();
        $patrols = $patrols->map(function ($patrol) {
            $patrol->tags = $patrol->tags->pluck('id')->toArray();
            return $patrol;
        });
        $siteguards = $site->guards()->orderBy('id', 'DESC')->get();
        $sitetags = $site->tags()->orderBy('id', 'DESC')->get();
        $guard = null;

        return view('admin.sites.patrols', compact('title', 'patrols', 'site', 'siteguards', 'sitetags', 'guard'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:50|string',
            'start' => 'required',
            'end' => 'required',
            'guard_id' => 'required',

        ]);

        try {
            DB::beginTransaction();

            $patrol = new Patrol();

            $patrol->company_id = auth()->user()->company_id;
            $patrol->site_id = $request->site_id;
            $patrol->guard_id = $request->guard_id;
            $patrol->name = $request->name;
            $patrol->start = $request->start;
            $patrol->end = $request->end;
            $patrol->type = 'scheduled';

            $patrol->save();

            $patrol_tags = $request->tags;
            $tag_ids = explode(',', $patrol_tags[0]);

            foreach ($tag_ids as $tag_id) {
                DB::table('patrol_tag')->insert([
                    'patrol_id' => $patrol->id,
                    'tag_id' => $tag_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            //create patrol history
            if ($tag_ids) {
                foreach ($tag_ids as $tag) {
                    $patrol->history()->create([
                        'tag_id' => $tag,
                        'guard_id' => $request->guard_id,
                        'company_id' => auth()->user()->company_id,
                        'site_id' => $request->site_id,
                        'date' => Carbon::now($patrol->site->timezone)->format('Y-m-d'),
                        'status' => 'upcoming',
                    ]);
                }
            }

            DB::commit();

            //log activity
            activity()
                ->performedOn($patrol)
                ->causedBy(auth()->user())
                ->withProperties(['guard_id' => $request->guard_id])
                ->log('Patrol created');

            return redirect()->back()->with('success', 'Patrol created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $siteId)
    {
        $request->validate([
            'edit_name' => 'required|min:3|max:50|string',
            'edit_start' => 'required',
            'edit_end' => 'required',
            'patrol_id' => 'required|exists:patrols,id',
        ]);

        try {
            DB::beginTransaction();

            $patrol = Patrol::findOrFail($request->patrol_id);
            $patrol->name = $request->edit_name;
            $patrol->start = $request->edit_start;
            $patrol->end = $request->edit_end;
            $patrol->save();

            $tagIds = explode(',', $request->tags);
            $patrol->tags()->sync($tagIds);

            $today = Carbon::now($patrol->site->timezone)->format('Y-m-d');
            $patrol->history()->delete();

            foreach ($tagIds as $tag) {
                $patrol->history()->create([
                    'tag_id' => $tag,
                    'guard_id' => $patrol->guard_id,
                    'company_id' => $patrol->company_id,
                    'site_id' => $patrol->site_id,
                    'date' => $today,
                    'status' => 'upcoming',
                ]);
            }

            DB::commit();

            //log activity
            activity()
                ->performedOn($patrol)
                ->causedBy(auth()->user())
                ->withProperties(['guard_id' => $patrol->guard_id])
                ->log('Patrol updated');

            return redirect()->back()->with('success', 'Patrol updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $patrol = Patrol::findOrFail($id);
        $patrol->delete();

        //log activity
        activity()
            ->performedOn($patrol)
            ->causedBy(auth()->user())
            ->log('Patrol deleted');

        return redirect()->back()->with('success', 'Patrol deleted successfully');
    }

    public function deleteMultiplePatrols(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:patrols,id',
        ]);

        $ids = $request->ids;

        $patrols = Patrol::whereIn('id', $ids)->get();

        foreach ($patrols as $patrol) {
            $patrol->delete();

            //log the patrol deletion
            activity()
                ->event('delete')
                ->performedOn($patrol)
                ->causedBy(auth()->user())
                ->log('Patrol deleted');
        }

        return response()->json([
            'success' => true,
            'message' => 'Patrols deleted successfully',
        ]);
    }
}
