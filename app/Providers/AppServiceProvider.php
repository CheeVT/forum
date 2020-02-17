<?php

namespace App\Providers;

use App\Board;
use Illuminate\Support\Facades\Schema;
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
        //\View::share('boards', Board::all());
        \View::composer('*', function($view) {
            $view->with('boards', Board::all());
        });
        Schema::defaultStringLength(191);
    }
}
