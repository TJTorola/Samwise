<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Invoice;

class SearchManagementProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Invoice::saved(function($invoice) {
            $invoice->addToIndex();
        });

        Invoice::restored(function($invoice) {
            $invoice->addToIndex();
        });

        Invoice::deleting(function($invoice) {
            if (!$invoice->trashed()) {
                $invoice->removeFromIndex();
            }
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
