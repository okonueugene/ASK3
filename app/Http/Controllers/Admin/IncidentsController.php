<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IncidentsController extends Controller
{
    public function index()
    {
        $data=Hash::make('123456');
        dd($data);
        return view('admin.incidents');
    }
}
