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
        if($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
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
            $boards = \Cache::rememberForever('boards', function () {
                return Board::all();
            });
            $view->with('boards', $boards);
        });
        Schema::defaultStringLength(191);
    }
}
