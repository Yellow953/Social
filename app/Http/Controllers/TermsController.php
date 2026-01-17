<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    /**
     * Show the terms of service page
     */
    public function index()
    {
        return view('terms');
    }
}
