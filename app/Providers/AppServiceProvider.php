<?php

namespace App\Providers;

use App\Entities\Senha;
use App\Observers\SenhaObserver;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Senha::observe(new SenhaObserver());
    }
}
