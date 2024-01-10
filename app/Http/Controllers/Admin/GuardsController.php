<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use App\Models\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'password' => 'required|min:6'
        ]);

        Guard::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'id_number' => $request->input('id_number'),
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect()->back()->with('success', 'Guard added successfully');
    }

    public function editGuard($id)
    {
        $guard = Guard::findOrFail($id);

        return response()->json([
            'message' => 'Guard fetched successfully',
            'guard' => $guard
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


        return response()->json(['status' => 200]);
    }

    public function updatePassword(Request $request, $id)
    {
        $guard = Guard::findOrFail($id);
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $guard->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json(['status' => 200]);
    }

    public function disassociateGuard($id)
    {
        $guard = Guard::where('id', $id)->update([
            'site_id' => null
        ]);

        return response()->json([
             'status' => 200
         ]);
    }


    public function changeGuardStatus($id)
    {
        $guard = Guard::findOrFail($id);
        $guard->update([
            'is_active' => !$guard->is_active
        ]);

        return response()->json([
            'message' => 'Guard status changed successfully'
        ]);
    }

    public function deleteGuard($id)
    {
        $guard = Guard::findOrFail($id);
        $guard->delete();
        return response()->json([
            'status' => 200
        ]);
    }

    public function assignGuardToSite(Request $request)
    {
        $guard = Guard::where('id', $request->guard_id)->update([
            'site_id' => $request->site_id
        ]);

        return response()->json([
            'success' => 'Guard assigned to site successfully'
        ]);
    }
}
