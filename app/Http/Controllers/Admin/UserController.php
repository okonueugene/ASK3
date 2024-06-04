<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $title = 'Users';
        $users = User::all();

        return view('admin.users', compact('users', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:50|confirmed',
            'password_confirmation' => 'required|min:8|max:50',
            'user_type' => 'required|in:admin,client',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);

        //log activity
        activity()
            ->event('created')
            ->causedBy(auth()->user())
            ->performedOn(User::latest()->first())
            ->useLog('User')
            ->log('added user');

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'sometimes|min:3|max:50|string',
            'new_email' => ['sometimes', 'email', 'unique:users,email,' . $id],
            'new_user_type' => 'sometimes|in:admin,client',
            'new_password' => 'sometimes|min:8|max:50',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->new_name,
            'email' => $request->new_email,
            'user_type' => $request->new_user_type,
            'password' => Hash::make($request->new_password),
        ]);

        //log activity
        activity()
            ->event('updated')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->useLog('User')
            ->log('updated user');

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        //log activity
        activity()
            ->event('deleted')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->useLog('User')
            ->log('deleted user');

        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
