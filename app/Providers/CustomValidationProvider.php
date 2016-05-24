<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
use Log;

use App\Offer;
use App\Item;

class CustomValidationProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Validator::extend('valid_cart', function($attribute, $cart, $parameters, $validator) {
			foreach ($cart as $offer_id => $items) {
				if (!Offer::where('id', '=', $offer_id)->exists()) {
					return false;
				}

				foreach ($items as $item_id => $count) {
					$item = Item::where('id', '=', $item_id)->first();
					if ($item === null) {
						return false;
					}

					if (!is_numeric($count)) {
						return false;
					}

					if (in_array('in_stock', $parameters) && !$item->infinite && $count > ($item->stock - $item->store_reserve)) {
						return false;
					}
				}
			}

			return true;
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
