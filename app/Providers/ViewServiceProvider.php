<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartCount = Auth::user()->cart()
                    ->where('is_checked_out', false)
                    ->sum('quantity');
                $view->with('cartCount', $cartCount);
            }
        });
    }
}
