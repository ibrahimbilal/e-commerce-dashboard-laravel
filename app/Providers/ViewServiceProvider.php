<?php

namespace App\Providers;

use App\Support\AdminSettingDefaults;
use App\Support\ThemeColors;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // variable to add '.rtl' extension to routes on RTL locales
        View::composer('*', function ($view) {
			$view->with('rtl_ext', is_rtl() ? '.rtl' : '');
        });

		// Admin Menu Items
        View::composer('admin.*', function ($view) {
			$view->with('menu_groups', array_to_object(get_dashboard_menu()));
        });

        View::composer('admin.layout', function ($view) {
            $view->with('themeCssVariables', ThemeColors::cssVariables());
        });

        View::composer('admin.settings.theme', function ($view) {
            $view->with('themeColorDefaults', AdminSettingDefaults::themeColorDefaults());
            $view->with('themeColorVariables', AdminSettingDefaults::themeColorVariableMeta());
        });
    }
}
