<?php

namespace App\Http\Controllers;

class AnalyticsController extends Controller
{
    public function overview()
    {
        return view('analytics.overview');
    }
}
