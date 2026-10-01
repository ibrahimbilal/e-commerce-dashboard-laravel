<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.partials.sidebar', function ($view) {
            $pendingStatusId = OrderStatus::query()
                ->get()
                ->first(fn (OrderStatus $status) => Str::slug($status->title) === 'pending')
                ?->id;

            $pendingOrdersCount = $pendingStatusId
                ? Order::query()->where('order_status_id', $pendingStatusId)->count()
                : 0;

            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }
}
