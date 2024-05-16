<?php

namespace App\Http\Controllers\Api\App;

use App\Events\MarkAttendance;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Guard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string|min:6|max:255',
        ]);
        $model = new Guard();

        $check = $model->where('phone', $request->phone)->exists();

        if ($check) {
            $guard = $model->where('phone', $request->phone)->first();
            //Password verification
            if (password_verify($request->password, $guard->password)) {
                //Auth pass
                $data['details'] = $guard;
                $data['token'] = $guard->createToken('authToken')->plainTextToken;
                //if guard is inactive
                if (!$guard->is_active) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Guard is Deactivated',
                    ], 200);
                }

                if ($guard->site_id) {

                    //update last login atttt
                    $guard->update([
                        'last_login_at' => Carbon::now($guard->site->timezone)->format('Y-m-d H:i:s'),
                    ]);

                    //mark attendance
                    $dateToday = Carbon::now($guard->site->timezone)->format('Y-m-d');
                    $present = Attendance::where('guard_id', $guard->id)->where('day', $dateToday)->first();

                    if (!$present) {
                        event(new MarkAttendance($guard));
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Guard not assigned to any site',
                    ], 200);
                }
                $sites = DB::table('sites')->where('id', $guard->site_id)->first();

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'id' => $guard->id,
                    'company_id' => $guard->company_id,
                    'site_id' => $sites->id,
                    'site_name' => $guard->site->name,
                    'name' => $guard->name,
                    'email' => $guard->email,
                    'phone' => $guard->phone,
                    'id_number' => $guard->id_number,
                    'is_active' => $guard->is_active,
                    'last_login_at' => $guard->last_login_at,
                    'token' => $data['token'],
                ], 200);
            } else {
                //Auth fail
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Phone number or Password',
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Phone number or Password',
            ], 200);
        }
    }

    public function logout()
    {
        $guard = Auth::user();

        $guard->tokens()->each(function ($token, $key) {
            $token->delete();
        });

        $time_out = Carbon::now($guard->site->timezone)->format('H:i:m');
        $day = Carbon::now($guard->site->timezone)->toDateString();

        $present = Attendance::where('guard_id', $guard->id)->where('day', $day)->first();

        if ($present) {
            $present->update([
                'time_out' => $time_out,
            ]);
        }

        if ($guard) {
            return response()->json([
                'success' => true,
                'message' => 'Logout successful',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
            ], 200);
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
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Guard profile not found',
            ], 200);
        }
    }

}
