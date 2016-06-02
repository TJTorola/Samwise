<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Invoice;
use App\InvoiceItem;
use App\Item;
use App\Offer;
use App\Payment;

use Log;

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

		InvoiceItem::deleted(function($invoiceItem) {
			$invoice = $invoiceItem->invoice;
			$invoice->addToIndex();
		});

		Payment::saved(function($payment) {
			$invoice = $payment->invoice;
			$invoice->addToIndex();
		});

		Item::saved(function($item) {
			$item->addToIndex();

			$offer = Offer::find($item->offer_id);
			$offer->addToIndex();
		});

		Item::deleted(function($item) {
			$item->removeFromIndex();

			$offer = Offer::find($item->offer_id);
			$offer->addToIndex();
		});

		Offer::saved(function($offer) {
			$offer->addToIndex();
		});

		Offer::deleted(function($offer) {
			$offer->removeFromIndex();
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
