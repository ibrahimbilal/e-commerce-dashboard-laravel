<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Support\AnalyticsReport;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view analytics');
    }

    public function overview(Request $request)
    {
        $range = AnalyticsReport::resolveRange(
            $request->query('from'),
            $request->query('to'),
            $request->query('compare', 'previous_period')
        );

        $analytics = AnalyticsReport::analytics($range);
        $analyticsSeries = AnalyticsReport::dailySeries($range);
        $topCategories = AnalyticsReport::topCategories($range);
        $topProducts = AnalyticsReport::topProducts($range);

        return view('admin.analytics.overview', compact(
            'range',
            'analytics',
            'analyticsSeries',
            'topCategories',
            'topProducts',
        ));
    }
}
