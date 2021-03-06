<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view){
            $channels = \Cache::rememberForever('channels', function(){
                return Channel::all();
            });

            $view->with('channels', $channels);
        });

        // For Heroku
        // https://laravel-news.com/laravel-5-4-key-too-long-error
        \Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
