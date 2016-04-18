<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Invoices\StoreRequest;
use App\Http\Requests\Invoices\UpdateRequest;
use App\Http\Requests\Invoices\StoreItemRequest;

use App\Search;
use App\Invoice;

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
		//
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
			'shipping_cost'
		];

		$invoice = Invoice::findOrFail($id);
		foreach ($request->all() as $key => $value) {
			if (!in_array($key, $allowed_fields)) {
				break;
			}
			$invoice[$key] = $value;
		}
		$invoice->save();
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

	public function storeItem(StoreItemRequest $request)
	{

	}

	public function indexPayments()
	{

	}

	public function storePayment(StorePaymentRequest $request)
	{

	}
}
