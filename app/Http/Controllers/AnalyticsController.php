<?php

namespace App\Http\Controllers;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view analytics');
    }

    public function overview()
    {
        return view('analytics.overview');
    }
}
