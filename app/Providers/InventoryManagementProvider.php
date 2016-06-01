<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Item;
use App\InvoiceItem;
use App\Invoice;
use Log;

class InventoryManagementProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/**
		 * When creating a new Cart Item, lets find the appropriate stock item and remove
		 * decrement it's stock and incrament it's sold. Unless of course the item has
		 * infinite stock. In which case we will add to it's sold value.
		 */
		InvoiceItem::creating(function($invoice_item) {
			if (isset($invoice_item['item_id'])) {
				$item = Item::findOrFail($invoice_item['item_id']);
				if (!$item->infinite) {
					$item->stock -= $invoice_item->count;
					$item->sold += $invoice_item->count;
					if ($item->stock < 0) {
						$item->stock = 0;
					}
					$item->save();
				}
			}
		});

		InvoiceItem::restored(function($invoice_item) {
			if (isset($invoice_item['item_id'])) {
				$item = Item::findOrFail($invoice_item['item_id']);
				if (!$item->infinite) {
					$item->stock -= $invoice_item->count;
					$item->sold += $invoice_item->count;
					if ($item->stock < 0) {
						$item->stock = 0;
					}
					$item->save();
				}
			}
		});

		/**
		 * When updating a cart item, we find that item and compare
		 * the old  count value  to the new and use this value to
		 * adjust the variant stock / sold info as necessary.
		 */
		InvoiceItem::updating(function($invoice_item) {
			$current_item = InvoiceItem::find($invoice_item->id);
			$count_change = $current_item->count - $invoice_item->count;

			if (isset($invoice_item['item_id'])) {
				$item = Item::findOrFail($invoice_item['item_id']);
				if (!$item->infinite) {
					$item->stock += $count_change;
					$item->save();
				}
			}
		});

		/**
		 * When deleting a cart item, you need to make sure and
		 * add those items back to the inventory, also, make
		 * sure that it doesn't look like those item's were sold.
		 */
		InvoiceItem::deleting(function($invoice_item) {
			if ($invoice_item->trashed()) {
				return;
			}

			if (isset($invoice_item['item_id'])) {
				$item = Item::findOrFail($invoice_item['item_id']);
				if (!$item->infinite) {
					$item->stock += $invoice_item->count;
					$item->sold -= $invoice_item->count;
					if ($item->sold < 0) {
						$item->sold = 0;
					}
					$item->save();
				}
			}
		});

		Invoice::deleted(function($invoice) {
			$invoice->items()->delete();
		});

		Invoice::restored(function($invoice) {
			$invoice->items()->withTrashed()->restore();
		});

		Invoice::deleting(function($invoice) {
			if ($invoice->trashed()) {
				return;
			}

			foreach ($variable as $key => $value) {
				# code...
			}
		});

		/**
		 * If a item changes in a dramatic way, make sure to decouple
		 * the item from it's cart item's, because the cart item's
		 * should not change from what the customer ordered
		 */
		Item::updating(function($item) {
			$current_item = Item::findOrFail($item->id);
			if ($item->price != $current_item->price
			 || $item->name != $current_item->name
			 || $item->weight != $current_item->weight
			 || $item->x != $current_item->x
			 || $item->y != $current_item->y
			 || $item->z != $current_item->z
			 || $item->unit != $current_item->unit
			)  {
				$invoice_items = InvoiceItem::where('item_id', $item->id)->get();
				foreach ($invoice_items as $invoice_item) {
					$invoice_item->item_id = null;
					$invoice_item->save();
					Log::info("Due to a change in item (id#$item[id]) Cart item (id#$item[id]) was decoupled from the inventory.");
				}
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
