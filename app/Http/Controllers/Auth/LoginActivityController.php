<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginActivityController extends Controller
{
    public function index()
    {
        $title = 'Login Activity';

        $activities = User::find(Auth::user()->id)->authentications()->paginate(10);

        // Retrieve additional information for each activity
        $activities = $activities->map(function ($activity) {
            $activity->userAgent = $this->parseUserAgent($activity->user_agent);
            $activity->location = $this->getLocation($activity->ip_address);
            $activity->statusBadge = $this->getStatusBadge($activity->login_successful);

            return $activity;
        });

        return view('auths.login-activity', compact('title', 'activities'));
    }

    private function getLocation($ip)
    {
        $ip = $ip == '127.0.0.1' ? '' : $ip;
        $url = "http://ip-api.com/json/{$ip}";
        $result = Http::get($url)->json();

        return $result['status'] == 'success' ? "{$result['regionName']}, {$result['country']}" : 'N/A';
    }

    private function getStatusBadge($loginSuccessful)
    {
        return $loginSuccessful == 1
            ? '<span class="badge bg-success text-white">Logged-In</span>'
            : '<span class="badge bg-danger text-white">LogIn-Failed</span>';
    }

    private function parseUserAgent($userAgent)
    {
        // Define patterns to match browser and OS
        $browserPattern = '/(?P<browser>\w+)\/(?P<version>\d+\.\d+\.\d+\.\d+)/';
        $osPattern = '/\((?P<os>\w+); (?P<os_version>\w+)\)/';

        // Find matches
        preg_match($browserPattern, $userAgent, $browserMatches);
        preg_match($osPattern, $userAgent, $osMatches);

        // Get browser and OS details
        $browser = $browserMatches[0] ?? 'Unknown';
        $os = $osMatches[0] ?? 'Unknown';

        // Return the result
        return "{$browser} on {$os}";
    }
}
