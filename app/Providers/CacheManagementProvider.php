<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Catalog;
use App\Page;
use Cache;

class CacheManagementProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Catalog::saving(function() {
            Cache::flush();
        });

        Page::saving(function() {
            Cache::flush();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
