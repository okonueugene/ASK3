<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendInvite;
use App\Models\Invitation;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ClientController extends Controller
{
    protected $paginationTheme = 'bootstrap';

    public function index()
    {
        $title = 'Clients';

        $clients = User::where('company_id', auth()->user()->company_id)
        ->where('user_type', 'client')
        ->orderBy('id', 'DESC')
        ->get();

        $sites = Site::where('company_id', auth()->user()->company_id)->get();

        $invitations = Invitation::where('company_id', auth()->user()->company_id)->paginate(10);

        return view('admin.client', compact('title', 'clients', 'sites', 'invitations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:50|confirmed',
            'password_confirmation' => 'required|min:8|max:50',
        ]);

        $user = User::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => 'client',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Client created successfully');
    }

    public function edit($id)
    {
        $client = User::findOrFail($id);

        return response()->json([
            'message' => 'Client fetched successfully',
            'client' => $client,
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|min:3|max:50|string',
            'email' => 'sometimes|email|unique:users,email,' . $client->id,
            'password' => 'sometimes|min:8|max:50|confirmed',
            'password_confirmation' => 'sometimes|min:8|max:50',
        ]);

        $client->update([
            $request->name ? 'name' : '' => $request->name,
            $request->email ? 'email' : '' => $request->email,
            $request->password ? 'password' : '' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client,
            'status' => 'success'
        ]);
    }

    public function delete($id)
    {
        $client = User::findOrFail($id);
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully',
            'status' => 'success'
        ]);
    }

    public function changeClientStatus($id)
    {
        $client = User::findOrFail($id);
        $status = $client->is_active == 1 ? 0 : 1;

        $client->update([
            'is_active' => $status
        ]);

        return response()->json([
            'message' => 'Client status updated successfully',
            'status' => 'success'
        ]);
    }

    public function assignSiteToClient(Request $request, $id)
    {
       $site = Site::findOrFail($request->site_id);

         $site->update([
              'user_id' => $id
         ]);

        return response()->json([
            'message' => 'Site assigned to client successfully',
            'status' => 'success'
        ]);
    }

    public function disassociateSiteFromClient($id)
    {
        $site = Site::where('user_id', $id)->first();

        $site->update([
            'user_id' => null
        ]);

        return response()->json([
            'message' => 'Site removed from client successfully',
            'status' => 'success'
        ]);
    }

    public function inviteClient(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

       $token =  sha1(time());

       $newInvitation = Invitation::create([
           'email' => $request->email,
           'token' => $token,
           'company_id' => auth()->user()->company_id,
           'user_id' => auth()->user()->id,
       ]);

       $url = URL::temporarySignedRoute(
        'accept-invitation',
        now()->addMinutes(30),
        ['email' => $request->email]
    );
    
        // Append the token as a query parameter
         $url .= '&token=' . $token;


         $mailData = [
            'url' => $url,
            'company' => $newInvitation->company->company_name,
            'name' => $request->name,
         ];

            Mail::to($newInvitation->email)->send(new SendInvite($mailData));

            return redirect()->back()->with('success', 'Invitation sent successfully');

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


        return view ('auths.accept-invite', compact('invitation', 'token'));
    }

    public function registerClient(Request $request)
    {
        // Validate the user input
        $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:50|confirmed',
            'password_confirmation' => 'required|min:8|max:50',
        ]);

        $token = $request->query('token');

        $invitation = Invitation::where('token', $token)->where('email', $request->email)->first();


      if (!$invitation || $invitation->is_accepted || $invitation->created_at->addMinutes(30)->isPast()) {
            // Render a view with a user-friendly message
            return view('auths.invalid-invitation');
        }

        $user = User::create([
            'company_id' => $invitation->company_id,
            'name' => $request->name,
            'email' => $invitation->email,
            'user_type' => 'client',
            'password' => Hash::make($request->password)
        ]);

      // Mark the invitation as accepted
      $invitation->update(['is_accepted' => true]);

      // Redirect to login with a success message
      return redirect()->route('login')->with('success', 'Client created successfully');
    }
    
}
