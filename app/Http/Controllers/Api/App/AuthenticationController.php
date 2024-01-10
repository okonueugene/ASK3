<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Guard;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|exists:guards,phone',
            'password' => 'required|string|min:6|max:255',
        ]);
    }

        
}