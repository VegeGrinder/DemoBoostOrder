<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
use App\Order;

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
        view()->composer('*', function ($view) {
            if(Auth::check() && Auth::user()->name === "User")
            {
                $notification = Order::where('user_id', Auth::id())->where('notification', 1)->first();

                $view->with('notification', $notification); //return to all view when there is a notification for the user
            }
        });
    }
}
