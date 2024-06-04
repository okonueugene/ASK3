<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendInvite;
use App\Models\Guard;
use App\Models\Invitation;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

        // Log activity
        activity()
            ->causedBy(auth()->user())
            ->event('created')
            ->performedOn(Guard::latest()->first())
            ->useLog('Guard')
            ->log('added guard');

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
            ->event('updated')
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
                'message' => 'Guard not found',
            ], 404);
        }

        DB::table('guards')->where('id', $request->guard_id)->update(['site_id' => $request->site_id]);

        activity()
            ->event('update')
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

    //invites guards to a site
    public function inviteGuardsToSite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:guards',
        ]);

        $token = md5(time() . $request->email);

        $newInvitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'company_id' => auth()->user()->company_id,
            'user_id' => auth()->user()->id,
        ]);

        $url = URL::temporarySignedRoute(
            'accept-guard-invitation',
            now()->addMinutes(30),
            ['email' => $request->email, 'token' => $token]
        );

        $mailData = [
            'url' => $url,
            'name' => $request->name,
            'company' => auth()->user()->company->name,
        ];

        $success = Mail::to($request->email)->send(new SendInvite($mailData));

        if ($success) {
            return redirect()->back()->with('success', 'Guard invited successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to invite guard');
        }

    }

    public function acceptInvite(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $invitation = Invitation::where('email', $email)->where('token', $token)->first();

        // Check if the invitation exists and is not accepted
        if (!$invitation || $invitation->is_accepted) {
            // Render a view with a user-friendly message
            return view('auths.invalid-invitation');
        }

        // Check if the invitation link has expired
        if ($invitation->created_at->addMinutes(30)->isPast()) {
            // Render a view with a user-friendly message
            return view('auths.expired-invitation');
        }

        return view('auths.accept-guard-invite', compact('invitation', 'token', 'email'));

    }

    public function registerGuard(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'phone' => 'required|numeric|regex:/^\d+$/',
            'id_number' => 'required|unique:guards',
            'email' => 'required|email|unique:guards',
        ]);

        $token = $request->query('token');

        $invitation = Invitation::where('token', $token)->first();

        // Check if the invitation exists and is not accepted
        if (!$invitation || $invitation->is_accepted || $invitation->created_at->addMinutes(30)->isPast()) {
            // Render a view with a user-friendly message
            return view('auths.invalid-invitation');
        }

        $guard = Guard::create([
            'company_id' => $invitation->company_id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'id_number' => $request->input('id_number'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Mark the invitation as accepted
        $invitation->update(['is_accepted' => true]);

        // Redirect to login with a success message
        if ($guard) {
            return redirect()->route('login')->with('success', 'Guard registered successfully');
        }

    }

    public function deleteInvitation($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->delete();

        return response()->json([
            'message' => 'Invitation deleted successfully',
        ]);
    }

}
