<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Invoice;
use App\InvoiceItem;

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

        InvoiceItem::saved(function($invoiceItem) {
            $invoice = $invoiceItem->invoice;
            $invoice->addToIndex();
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
