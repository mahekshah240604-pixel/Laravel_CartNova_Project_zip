<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the home / dashboard page.
     * Route: GET /
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('home', compact('user'));
    }
}