<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SosController extends Controller
{
    public function index()
    {
        $title = 'SOS';
        $sos = Sos::orderBy('id', 'desc')->get();
        
        $sos->load('owner', 'site', 'company');
        return view('admin.sos', compact('title', 'sos'));
    }
}
