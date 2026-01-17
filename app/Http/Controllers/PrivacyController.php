<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    /**
     * Show the privacy policy page
     */
    public function index()
    {
        return view('privacy');
    }
}
