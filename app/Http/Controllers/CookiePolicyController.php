<?php

namespace App\Http\Controllers;

class CookiePolicyController extends Controller
{
    /**
     * Show the cookie policy page
     */
    public function index()
    {
        return view('cookie-policy');
    }
}
