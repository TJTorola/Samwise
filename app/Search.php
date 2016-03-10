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
use App\ItemVariant;
use App\Page;
use App\User;

class Search
{
  /**
   * Index all the models that are set to be indexed.
   */
  static public function index()
  {
    Customer::createIndex($shards = null, $replicas = null);

    // Customer index
    Customer::putMapping($ignoreConflicts = true);
    $customer_chunks = Customer::all()->chunk(50);
    foreach ($customer_chunks as $customers) {
      $customers->addToIndex();
    }

    // Invoice index
    Invoice::putMapping($ignoreConflicts = true);
    $invoice_chunks = Invoice::all()->chunk(50);
    foreach ($invoice_chunks as $invoices) {
      $invoices->addToIndex();
    }

    // Item index
    Item::putMapping($ignoreConflicts = true);
    $item_chunks = Item::all()->chunk(50);
    foreach ($item_chunks as $items) {
      $items->addToIndex();
    }

    // Item Variant index
    ItemVariant::putMapping($ignoreConflicts = true);
    $item_variant_chunks = ItemVariant::all()->chunk(50);
    foreach ($item_variant_chunks as $item_variants) {
      $item_variants->addToIndex();
    }
  }

  /**
   * Refresh the index of all the models that are set to be indexed.
   */
  static public function reindex()
  {}

  public function query($index, QueryRequest $request)
  {
    // validate the request
    // Set index specific variables
    $indices = ['catalogs','customers','invoices','invoice-items','items','item-variants','pages','users'];
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
    $searchable = ['customers', 'invoices', 'items', 'item-variants'];
    if (in_array($index, $searchable)) {
      $response = $this.search($index, $request);
    } else {
      $response = $this.collect($index, $request);
    }

    return $response;

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

  public function search($index, Request $request)
  {
    // If there is no query, just collect the items
    if ($request->has('_query')) {
      return $this.collect($index, $request);
    }

    // Take the query and brake it into an array for ES
    $query = $request->_query;
    $query = explode(" ", strtolower($query));

    // Search the last word as a prefix, all the others as full
    $full = array_slice($query, 0, -1);
    $prefix = end($query);

    // Build the query structure
    $query = array();
    $query['bool']['should'] = array();
    foreach ($full as $key) {
      array_push($query['bool']['should'], [ "match" => ["_all" => $key ]]);
    }
    array_push($query['bool']['should'], [ "prefix" => ["_all" => $prefix ]]);

    // search the appropriate index
    if ($index == 'customers') {
      $results = Customer::searchByQuery($query);
    } else if ($index == 'invoices') {
      $results = Invoice::searchByQuery($query);
    } else if ($index == 'items') {
      $results = Item::searchByQuery($query);
    } else if ($index == 'item-variants') {
      $results = ItemVariant::searchByQuery($query);
    } else {
      return response()->json(['$index' => ['Chunking index was not found.']], 500);
    }

    // build/return the response
    $collection = collect($results->getItems());
    return $collection;
  }

  public function collect($index, Request $request)
  {
    // set defaults
    $page = 0;
    $limit = env('STORE_COLLECTION_LIMIT', 25);

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
    } else if ($index == 'invoice-items') {
      $collection = InvoiceItem::all();
    } else if ($index == 'items') {
      $collection = Item::all();
    } else if ($index == 'item-variants') {
      $collection = ItemVariant::all();
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
      return response()->json(['_page' => ['Page does not exist for the set limit.']], 422);
    } else {
      $collection = $collection[$page];
    }

    return [
      'length' => $length,
      'body' => $collection
    ]
  }
}
