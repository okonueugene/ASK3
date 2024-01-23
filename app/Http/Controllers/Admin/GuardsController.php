<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuardsController extends Controller
{
    public function index()
    {
        $title = 'Guards';

        $guards = Guard::where('company_id', auth()->user()->company_id)->orderBy('id', 'DESC')->get();
        $sites = Site::where('company_id', auth()->user()->company_id)->get();
        $freeGuards = Guard::where('company_id', auth()->user()->company_id)->whereNull('site_id')->get();

        return view('admin.guards', compact('guards', 'title', 'sites', 'freeGuards'));
    }

    public function addGuard(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:guards',
            'phone' => 'required|numeric|regex:/^\d+$/|unique:guards',
            'id_number' => 'required|unique:guards',
            'password' => 'required|min:6',
        ]);

        Guard::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'id_number' => $request->input('id_number'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->back()->with('success', 'Guard added successfully');
    }

    public function editGuard($id)
    {
        $guard = Guard::findOrFail($id);

        return response()->json([
            'message' => 'Guard fetched successfully',
            'guard' => $guard,
        ]);
    }

    public function updateGuard(Request $request, $id)
    {
        $guard = Guard::findOrFail($id);
        $request->validate([
            'email' => 'sometimes|email|unique:guards,email,' . $guard->id,
            'phone' => 'sometimes|numeric|regex:/^\d+$/|unique:guards,phone,' . $guard->id,
            'id_number' => 'sometimes|unique:guards,id_number,' . $guard->id,
        ]);

        $guard->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'id_number' => $request->input('id_number'),
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($guard)
            ->withProperties(['guard' => $guard])
            ->useLog('Guard')
            ->log('updated guard');

        return response()->json(['status' => 200]);
    }

    public function updatePassword(Request $request, $id)
    {
        $guard = Guard::findOrFail($id);
        $request->validate([
            'password' => 'required|min:6',
        ]);

        $guard->update([
            'password' => Hash::make($request->input('password')),
        ]);

        activity()
            ->causedBy(auth()->user())
            ->event('updated')
            ->withProperties(['guard' => $guard])
            ->performedOn($guard)
            ->useLog('Guard')
            ->log('updated guard password');

        return response()->json(['status' => 200]);
    }

    public function disassociateGuard($id)
    {
        $guard = Guard::find($id);

        if ($guard) {
            DB::table('guards')->where('id', $id)->update(['site_id' => null]);
        }

        activity()
            ->causedBy(auth()->user())
            ->event('updated')
            ->withProperties(['guard' => $guard])
            ->performedOn($guard)
            ->useLog('Guard')
            ->log('disassociated guard from site');

        return response()->json([
            'status' => 200,
        ]);
    }

    public function changeGuardStatus($id)
    {
        $guard = Guard::findOrFail($id);
        $guard->update([
            'is_active' => !$guard->is_active,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->event('updated')
            ->withProperties(['guard' => $guard])
            ->performedOn($guard)
            ->useLog('Guard')
            ->log('changed guard status');

        return response()->json([
            'message' => 'Guard status changed successfully',
        ]);
    }

    public function deleteGuard($id)
    {
        $guard = Guard::findOrFail($id);
        $guard->delete();

        activity()
            ->causedBy(auth()->user())
            ->event('deleted')
            ->withProperties(['guard' => $guard])
            ->performedOn($guard)
            ->useLog('Guard')
            ->log('deleted guard');

        return response()->json([
            'status' => 200,
        ]);
    }

    public function assignGuardToSite(Request $request)
    {
        $guard = Guard::findOrfail($request->guard_id);
   
        if (!$guard) {
            return response()->json([
                'message' => 'Guard not found'
            ], 404);
        }

        DB::table('guards')->where('id', $request->guard_id)->update(['site_id' => $request->site_id]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($guard)
            ->withProperties(['site_id' => $request->site_id])
            ->useLog('Guard')
            ->log('assigned guard to site');

        return response()->json([
            'success' => 'Guard assigned to site successfully',
        ]);
    }

    public function getSiteGuards($id)
    {
        $guards = Site::findOrFail($id)->guards;

        return response()->json([
            'guards' => $guards,
            'id' => $id,
        ]);
    }
}
