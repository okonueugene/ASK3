<?php

namespace App\Http\Controllers\Api\App;

use App\Models\Guard;
use Illuminate\Http\Request;
use App\Events\MarkAttendance;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|exists:guards,phone',
            'password' => 'required|string|min:6|max:255',
        ]);

        $model = new Guard();

        $check = $model->where('phone', $request->phone)->exists();

        if ($check) {
            $guard = $model->where('phone', $request->phone)->first();
            //Password verification
            if (password_verify($request->password, $guard->password)) {
                //Auth pass
                $data['deatils'] = $guard;
                $data['token'] = $guard->createToken('API TOKEN')->accessToken;

                $guard->update([
                    'last_login' => Carbon::now($guard->timezone)->toDateTimeString(),
                ]);

                //mark attendance
                $dateToday = Carbon::now($guard->timezone)->format('Y-m-d');
                $present = Attendance::where('guard_id', $guard->id)->where('date', $dateToday)->first();

                if (!$present) {
                   event(new MarkAttendance($guard));
                }

                $sites = DB::table('sites')->where('id', $guard->site_id)->value('name');

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'id' => $guard->id,
                    'company_id' => $guard->company_id,
                    'site_id' => $sites,
                    'name' => $guard->name,
                    'email' => $guard->email,
                    'phone' => $guard->phone,
                    'id_number' => $guard->id_number,
                    'is_active' => $guard->is_active,
                    'last_login_at' => $guard->name,
                    'data' => $data['token'],
                ], 201);
            } else {
                //Auth fail
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Credentials',
                ], 204);
            }
        } else {
            //Auth fail
            return response()->json([
                'success' => false,
                'message' => 'Guard with this phone does not exist',
            ], 204);
        }
    }

    public function logout()
    {
        $guard = auth()->guard('guard')->user();

        $guard->tokens()->each(function ($token, $key) {
            $token->delete();
        });

        $time_out = Carbon::now($guard->site->timezone)->format('H:i:m');
        $day = Carbon::now($guard->site->timezone)->toDateString();

        $present = Attendance::where('guard_id', $guard->id)->where('date', $day)->first();

        if ($present) {
            $present->update([
                'time_out' => $time_out,
            ]);
        }

        if($guard)
        {
            return response()->json([
                'success' => true,
                'message' => 'Logout successful',
            ], 201);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
            ], 204);
        }
    }
    
    public function profile()
    {

        $guard = Auth::guard('guard')->user();

        if ($guard) {
            return response()->json([
                'success' => true,
                'message' => 'Guard profile',
                'data' => $guard,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Guard profile not found',
            ], 204);
        }
    }

        
}