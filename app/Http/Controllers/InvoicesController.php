<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Invoices\StoreRequest;
use App\Http\Requests\Invoices\UpdateRequest;
use App\Http\Requests\Invoices\StoreItemRequest;
use App\Http\Requests\Invoices\StoreItemsRequest;
use App\Http\Requests\Invoices\StorePaymentRequest;

use App\Search;
use App\Invoice;
use App\InvoiceItem;
use App\Payment;
use App\Item;
use JWTAuth;

use Stripe\Stripe;
use Stripe\Charge;

class InvoicesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, Search $search)
	{
		return $search->query('invoices', $request);
	}

	/**
	 * Display a listing of the deleted resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexCancelled(Request $request, Search $search)
	{
		return $search->query('cancelled-invoices', $request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request)
	{
		$invoice = Invoice::create($request->all());
		InvoiceItem::saveMany($request->cart, $invoice->id);

		return $invoice;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return Invoice::findOrFail($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$allowed_fields = [
			'store_notes',
			'email',
			'phone',
			'seperate_billing',
			'billed',
			'paid',
			'shipped',
			'shipping_cost',
			'billing_address',
			'shipping_address'
		];

		$invoice = Invoice::findOrFail($id);
		foreach ($request->all() as $key => $value) {
			if (!in_array($key, $allowed_fields)) {
				break;
			}
			$invoice[$key] = $value;
		}
		$invoice->save();
		sleep(1);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		Invoice::withTrashed()->findOrFail($id)->forceDelete();
		sleep(1);
	}

	/**
	 * Soft delete specific resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function cancel($id)
	{
		Invoice::findOrFail($id)->delete();
		sleep(1);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function restore($id)
	{
		Invoice::withTrashed()->findOrFail($id)->restore();
		sleep(1);
	}

	public function indexItems()
	{

	}

	public function storeItem($id, StoreItemRequest $request)
	{
	}

	public function storeItems($id, StoreItemsRequest $request) {
		$invoice = Invoice::findOrFail($id);

		foreach ($request->deleted as $deleted_id) {
			InvoiceItem::find($deleted_id)->delete();
		}

		$invoice_items = [];
		foreach ($request->items as $item) {
			if ($item['id'] != null) {
				// update existing item
				$old_item = InvoiceItem::find($item['id']);

				if ($item['item_id'] != null) {
					$old_item->count = $item['count'];
				} else {
					$old_item->item_id = null;
					$old_item->name = $item['name'];
					$old_item->count = $item['count'];
					$old_item->price = $item['price'];
					$old_item->unit = $item['unit'];
				}

				$old_item->save();
				continue;
			}

			// add new item
			if ($item['item_id'] != null) {
				// add from inventory stock
				$inv_item = Item::find($item['item_id']);

				$invoice_items[] = new InvoiceItem([
					'item_id' => $item['item_id'],
					'name' => $inv_item->full_newline_name,
					'count' => $item['count'],
					'price' => $inv_item->price,
					'unit' => $inv_item->unit
				]);
			} else {
				// add as unstocked item
				$invoice_items[] = new InvoiceItem([
					'item_id' => null,
					'name' => $item['name'],
					'count' => $item['count'],
					'price' => $item['price'],
					'unit' => $item['unit']
				]);
			}
		}
		$invoice->items()->saveMany($invoice_items);

		sleep(1);
		return $request->all();
	}

	public function indexPayments()
	{

	}

	public function storePayment($id, StorePaymentRequest $request)
	{
		Stripe::setApiKey(env('STRIPE_SECRET'));

		$invoice = Invoice::findOrFail($id);
		$token = $request->token;

		if ($request->amount != $invoice->due) {
			// THROW ERROR
			// AMT User thought they were paying has changed
			// OR something more seedy is going on with them
		}

		try
		{
			$charge = Charge::create([
				'amount' => $invoice->due,
				'currency' => 'usd',
				'description' => "INV$id",
				'card' => $token['id']
			]);

			$user = JWTAuth::parseToken()->authenticate();

			$payment = [
				'user_id' => $user->id,
				'stripe_id' => $charge['id'],
				'amount' => $charge['amount'],
				'currency' => $charge['currency'],
				'card_brand' => $charge['source']['brand'],
				'last_four' => $charge['source']['last4']
			];

			$payment = $invoice->payments()->save(new Payment($payment));
			$payment['user'] = $payment->user->name;
			sleep(1);

			return $payment;

		} catch(\Stripe\Error\Card $e) {

			return response()->json(['Card Declined' => [$e->getStripeCode()]], 422);

		} catch (Stripe_InvalidRequestError $e) {
			// Invalid parameters were supplied to Stripe's API
			return response()->json('Stripe_InvalidRequestError.', 422);

		} catch (Stripe_AuthenticationError $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			return response()->json('Stripe_AuthenticationError.', 422);

		} catch (Stripe_ApiConnectionError $e) {
			// Network communication with Stripe failed
			return response()->json('Stripe_ApiConnectionError.', 422);

		} catch (Stripe_Error $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			return response()->json('Stripe_Error.', 422);

		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			return response()->json('Exception.', 422);

		}
	}
}
