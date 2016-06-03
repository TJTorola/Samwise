<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Pub\StoreInvoiceRequest;

use App;
use Cache;
use Mail;

use App\Offer;
use App\Page;
use App\User;
use App\Catalog;
use App\Search;
use App\Invoice;
use App\InvoiceItem;

class PublicController extends Controller
{
	public function indexMenus()
	{
		$menus = Cache::rememberForever('menus', function() {
			return array_merge(Page::getMenus(), Catalog::getMenu());
		});

		return $menus;
	}

	public function indexOffers(Request $request, Search $search)
	{
		// decode existing must, if there is any
		if ($request['_must'] == null) {
			$must = [];
		} else {
			$must = json_decode($request['_must'], true);
		}

		// append/change public to must be true
		$must['public'] = true;
		$request['_must'] = json_encode($must);

		return $search->query('offers', $request);
	}

	public function showCatalog($id)
	{
		return Catalog::findOrFail($id);
	}

	public function showOffer($id)
	{
		$offer = Offer::findOrFail($id);

		if ($offer->public) return $offer->toPublicArray();
		App::abort(404);
	}

	public function showPage($slug)
	{
		foreach (Page::all() as $page) {
			if ($page->path == "/$slug") {
				return $page;
			}
		}
		App::abort(404);
	}

	public function storeInvoice(StoreInvoiceRequest $request)
	{
		$invoice = Invoice::create($request->all());
		InvoiceItem::saveMany($request->cart, $invoice->id);

		Mail::queue('emails.invoice', ['invoice' => $invoice], function($message) use ($invoice) {
			// TODO: Add email setting
			$message->from('info@pangolin4x4.com');
			$message->to($invoice->email);
			$message->subject("Pangolin4x4: INV".$invoice->id);
		});

		$users = User::all();
		foreach ($users as $user) {
			Mail::queue('emails.newInvoiceNotification', ['invoice' => $invoice, 'user' => $user], function($message) use ($invoice, $user) {
				$message->from('info@pangolin4x4.com');
				$message->to($user->email);
				$message->subject("[p4x4] NEW ORDER - INV".$invoice->id);
			});
		}

		return $invoice;
	}

	public function settings()
	{
		return config("samwise.store_info");
	}
}
