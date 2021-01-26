<?php

namespace App\Providers;

use \Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
//        $this->app->singleton(View::class, \App\Http\View\Composers\BootComposer::class);
        View::composer('layout.app', 'App\Http\View\Composers\BootComposer');
    }
}
