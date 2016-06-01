<?php

namespace App;

use Illuminate\Http\Request;
use App\Http\Requests;

use Validator;

use App\Http\Requests\Search\QueryRequest;

use App\Catalog;
use App\Customer;
use App\Invoice;
use App\InvoiceItem;
use App\Item;
use App\Offer;
use App\Page;
use App\User;

class Search
{
	/**
	 * Index all the models that are set to be indexed.
	 *
	 * Only to be ran once, initally, when there is no existing elasticsearch index
	 * this will initalize the index and then add all documents to it.
	 *
	 * @return void
	 */
	static public function index()
	{
		Offer::createIndex($shards = null, $replicas = null);

		// Customer index
		// Customer::putMapping($ignoreConflicts = true);
		$customer_chunks = Customer::all()->chunk(50);
		foreach ($customer_chunks as $customers) {
			$customers->addToIndex();
		}

		// Invoice index
		// Invoice::putMapping($ignoreConflicts = true);
		$invoice_chunks = Invoice::all()->chunk(50);
		foreach ($invoice_chunks as $invoices) {
			$invoices->addToIndex();
		}

		// offer index
		Offer::putMapping($ignoreConflicts = true);
		$offer_chunks = Offer::all()->chunk(50);
		foreach ($offer_chunks as $offers) {
			$offers->addToIndex();
		}

		// Item index
		// Item::putMapping($ignoreConflicts = true);
		$item_chunks = Item::all()->chunk(50);
		foreach ($item_chunks as $items) {
			$items->addToIndex();
		}
	}

	/**
	 * Refresh the index of all the models that are set to be indexed.
	 *
	 * @return void
	 */
	static public function reindex()
	{}

	/**
	 * Query the state for a collection of resources.
	 *
	 * This will take a query request, and index to query, decide which engine
	 * to use (laravel-db/elasticsearch), dispatch that request, then build the
	 * response with the collection.
	 *
	 * @param string $index the index to query
	 * @param Request $request the client provided request
	 *
	 * @return array
	 */
	public function query($index, Request $request)
	{
		// validate the request
		// Set index specific variables
		$indices = ['catalogs','customers','invoices','cancelled-invoices','invoice-items','items','offers','pages','users'];
		if (in_array($index, $indices)) {
			$base_href = "/$index";
		} else {
			return response()->json(['$index' => ['Chunking index was not found.']], 500);
		}

		// Validate $request params
		$validator = Validator::make($request->all(), [
			'_page' => 'integer|min:0',
			'_limit' => 'integer|min:0',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 422);
		}

		// determine if we will use ES or laravel
		// get the collection
		// functions should return the total items for the query
		// and the particular chunk asked for
		$searchable = ['customers', 'invoices', 'items', 'offers'];
		if (in_array($index, $searchable)) {
			$response = $this->search($index, $request);
		} else {
			$response = $this->collect($index, $request);
		}

		// unpack response
		$page = $response['_page'];
		$limit = $response['_limit'];
		$pages = $response['pages'];
		$length = $response['length'];
		$body = $response['body'];

		// chunk and format the response
		// calculate next page
		$next_page = $page + 1;
		if ($next_page >= $pages) {
			$next_page = 0;
		}

		// calculate prev page
		$prev_page = $page - 1;
		if ($prev_page < 0) {
			$prev_page = $pages - 1;
		}

		$href_params = [];
		$next_params = [];
		$prev_params = [];

		if ($request->has('_query')) {
			$query = $request->_query;
			$href_params[] = "_query=$query";
			$next_params[] = "_query=$query";
			$prev_params[] = "_query=$query";
		}

		if ($request->has('_limit')) {
			$href_params[] = "_limit=$limit";
			$next_params[] = "_limit=$limit";
			$prev_params[] = "_limit=$limit";
		}

		if ($page != 0) {
			$href_params[] = "_page=$page";
		}
		if ($next_page != 0) {
			$next_params[] = "_page=$next_page";
		}
		if ($prev_page != 0) {
			$prev_params[] = "_page=$prev_page";
		}

		if (count($href_params) > 0) {
			$href = "$base_href?".implode("&", $href_params);
		} else {
			$href = "$base_href";
		}

		if (count($next_params) > 0) {
			$next = "$base_href?".implode("&", $next_params);
		} else {
			$next = "$base_href";
		}

		if (count($prev_params) > 0) {
			$prev = "$base_href?".implode("&", $prev_params);
		} else {
			$prev = "$base_href";
		}

		// if there is only one page, set next/prev to null
		if ($pages <= 1) {
			$prev = null;
			$next = null;
		}

		return [
		'_page' => $page,
		'_limit' => $limit,
		'href' => $href,
		'next' => $next,
		'prev' => $prev,
		'length' => $length,
		'pages' => $pages,
		'body' => $body
		];
	}

	/**
	 * Collect the requested collection using elasticsearch.
	 *
	 * @param string $index the index to query
	 * @param Request $request the client provided request
	 *
	 * @return array
	 */
	public function search($index, Request $request)
	{
		$must = [];
		$should = [];
		$must_not = [];

		// Add the full text query to the must query
		if ($request->has('_query')) {
			// Take the query and brake it into an array for ES
			$query = $request->_query;
			$query = explode(" ", strtolower($query));

			// Search the last word as a prefix, all the others as full
			$full = array_slice($query, 0, -1);
			$prefix = end($query);

			foreach ($full as $key) {
				$must[] = [ "match" => ["_all" => $key ]];
			}
			$must[] = [ "prefix" => ["_all" => $prefix ]];
		}

		// Add defined must rules
		if ($request->has('_must')) {
			$rules = $request->_must;
			$rules = json_decode($rules);
			foreach ($rules as $rule => $terms) {
				if (is_array($terms)) {
					$must[] = [ 'terms' => [ $rule => $terms]];
				} else {
					$must[] = [ 'term' => [ $rule => $terms]];
				}
			}
		}

		// Add defined should rules
		if ($request->has('_should')) {
			$rules = $request->_should;
			$rules = json_decode($rules);
			foreach ($rules as $rule => $terms) {
				if (is_array($terms)) {
					$should[] = [ 'terms' => [ $rule => $terms ]];
				} else {
					$should[] = [ 'term' => [ $rule => $terms ]];
				}
			}
		}

		// Add defined must not rules
		if ($request->has('_must_not')) {
			$rules = $request->_must_not;
			$rules = json_decode($rules);
			foreach ($rules as $rule => $terms) {
				if (is_array($terms)) {
					$must_not[] = [ 'terms' => [ $rule => $terms]];
				} else {
					$must_not[] = [ 'term' => [ $rule => $terms]];
				}
			}
		}

		$query = [];
		if (count($must)) {
			$query['bool']['must'] = $must;
		}

		if (count($must_not)) {
			$query['bool']['must_not'] = $must_not;
		}

		if (count($should)) {
			$query['bool']['should'] = $should;
		}

		// dd($query);

		// set defaults for page/limit
		$page = 0;
		$limit = env('STORE_COLLECTION_LIMIT', 10);

		// set requested page/limit
		if ($request->has('_page')) {
			$page = (int)$request->_page;
		}
		if ($request->has('_limit')) {
			$limit = (int)$request->_limit;
		}

		// Build sorting array
		if ($request->has('_sort')) {
			$sort = $request->_sort;
			$sort = json_decode($sort);
		} else {
			$sort = ['id' => 'asc'];
		}

		// ES uses offset rather than chunks
		$offset = $page * $limit;

		// search the appropriate index
		if ($index == 'customers') {
			$results = Customer::searchByQuery($query, $limit, $offset, $sort);
		} else if ($index == 'invoices') {
			$results = Invoice::searchByQuery($query, $limit, $offset, $sort);
		} else if ($index == 'items') {
			$results = Item::searchByQuery($query, $limit, $offset, $sort);
		} else if ($index == 'offers') {
			$results = Offer::searchByQuery($query, $limit, $offset, $sort);
		} else {
			return response()->json(['$index' => ['Chunking index was not found.']], 500);
		}

		// build/return the response
		$collection = collect($results->getItems());
		$length = $results->totalHits();
		$pages = ceil($length / $limit);

		return [
			'_page' => $page,
			'_limit' => $limit,
			'pages' => $pages,
			'length' => $length,
			'body' => $collection
		];
	}

	/**
	 * Collect the request collection using Laravel.
	 *
	 * @param string $index the index to query
	 * @param Request $request the client provided request
	 *
	 * @return array
	 */
	public function collect($index, Request $request)
	{
		// set defaults
		$page = 0;
		$limit = env('STORE_COLLECTION_LIMIT', 10);

		// set requested page/limit
		if ($request->has('_page')) {
			$page = $request->_page;
		}
		if ($request->has('_limit')) {
			$limit = $request->_limit;
		}

		// Set index specific variables
		if ($index == 'catalogs') {
			$collection = Catalog::all();
		} else if ($index == 'customers') {
			$collection = Customer::all();
		} else if ($index == 'invoices') {
			$collection = Invoice::all();
		} else if ($index == 'cancelled-invoices') {
			$collection = Invoice::onlyTrashed()->get();
		} else if ($index == 'invoice-items') {
			$collection = InvoiceItem::all();
		} else if ($index == 'items') {
			$collection = Item::all();
		} else if ($index == 'offers') {
			$collection = Offer::all();
		} else if ($index == 'pages') {
			$collection = Page::all();
		} else if ($index == 'users') {
			$collection = User::all();
		} else {
			return response()->json(['$index' => ['Chunking index was not found.']], 500);
		}

		// Set counts and chunk collection
		$length = count($collection);
		$collection = $collection->chunk($limit);
		$pages = count($collection);

		// Check if page exists, if not, throw error
		if (!isset($collection[$page])) {
			$page = count($collection) - 1;
		}

		if ($page < 0) {
			$page = 0;
			$collection = [];
		} else {
			$collection = $collection[$page];
		}

		return [
			'_page' => $page,
			'_limit' => $limit,
			'pages' => $pages,
			'length' => $length,
			'body' => $collection
		];
	}
}
