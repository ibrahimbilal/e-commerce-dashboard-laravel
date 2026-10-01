<?php

namespace App\Http\Controllers;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view marketing');
    }

    public function index()
    {
        return view('marketing.index');
    }
}
