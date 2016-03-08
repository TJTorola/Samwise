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
  {
  }

  public function query($index, QueryRequest $request)
  {

  }

	// /**
 //   * Returns a collection of models from the provided index using params from
 //   * a provided request. This only uses default laravel collection functions
 //   * as a alternative to query() which uses elastic search.
 //   *
 //   * @param  string $index
 //   * @param  \Illuminate\Http\Request  $request
 //   * @return \Illuminate\Http\Response
 //   */
 //  public function chunk($index, Request $request, $collection)
 //  {
 //  	// Set index specific variables
 //    $indices = ['catalogs','customers','invoices','invoice-items','items','item-variants','pages','users'];
 //    if (in_array($index, $indices)) {
 //      $base_href = "/$index";
 //  	} else {
 //  		return response()->json(['$index' => ['Chunking index was not found.']], 500);
 //  	}
  	
 //  	// Validate $request params
 //  	$validator = Validator::make($request->all(), [
 //      '_page' => 'integer|min:0',
 //      '_limit' => 'integer|min:0',
 //    ]);

 //    if ($validator->fails()) {
 //      return response()->json($validator->errors(), 422);
 //    }

 //  	// Set the collection slice params
 //    $page = 0;
 //    $limit    = env('STORE_COLLECTION_LIMIT', 25);
 //    if ($request->has('_page')) {
 //      $page = $request->_page;
 //    }
 //    if ($request->has('_limit')) {
 //      $limit = $request->_limit;
 //    }

 //    // set basic collection info
 //    $length = $collection->count();
 //    $collection = $collection->chunk($limit);
 //    $pages = count($collection);

 //    // set the current, next, and prev hrefs

 //    // calculate next page
 //    $next_page = $page + 1;
 //    if ($next_page >= $pages) {
 //      $next_page = 0;
 //    }

 //    // calculate prev page
 //    $prev_page = $page - 1;
 //    if ($prev_page < 0) {
 //      $prev_page = $pages - 1;
 //    }

 //    $href_params = [];
 //    $next_params = [];
 //    $prev_params = [];

 //    if ($request->has('_query')) {
 //      $query = $request->_query;
 //      $href_params[] = "_query=$query";
 //      $next_params[] = "_query=$query";
 //      $prev_params[] = "_query=$query";
 //    }

 //    if ($request->has('_limit')) {
 //      $href_params[] = "_limit=$limit";
 //      $next_params[] = "_limit=$limit";
 //      $prev_params[] = "_limit=$limit";
 //    }

 //    if ($page != 0) {
 //      $href_params[] = "_page=$page";
 //    }
 //    if ($next_page != 0) {
 //      $next_params[] = "_page=$next_page";
 //    }
 //    if ($prev_page != 0) {
 //      $prev_params[] = "_page=$prev_page";
 //    }

 //    if (count($href_params) > 0) {
 //      $href = "$base_href?".implode("&", $href_params);
 //    } else {
 //      $href = "$base_href";
 //    }

 //    if (count($next_params) > 0) {
 //      $next = "$base_href?".implode("&", $next_params);
 //    } else {
 //      $next = "$base_href";
 //    }

 //    if (count($prev_params) > 0) {
 //      $prev = "$base_href?".implode("&", $prev_params);
 //    } else {
 //      $prev = "$base_href";
 //    }

 //    // Check if page exists, if not, throw error
 //    if (!isset($collection[$page])) {
 //      return response()->json(['_page' => ['Page does not exist for the set limit.']], 422);
 //    } else {
 //      $body = $collection[$page];
 //    }

 //    return [
 //      '_page' => $page,
 //      '_limit' => $limit,
 //      'href' => $href,
 //      'next' => $next,
 //      'prev' => $prev,
 //      'length' => $length,
 //      'pages' => $pages,
 //      'body' => $body
 //    ];
 //  }

 //  public function query($index, $query, $limit, $page)
 //  {
 //    $query = explode(" ", strtolower($query));
 //    $full = array_slice($query, 0, -1);
 //    $prefix = end($query);

 //    $query = array();
 //    $query['bool']['should'] = array();
 //    foreach ($full as $key) {
 //      array_push($query['bool']['should'], [ "match" => ["_all" => $key ]]);
 //    }
 //    array_push($query['bool']['should'], [ "prefix" => ["_all" => $prefix ]]);

 //    if ($index == 'customers') {
 //      $results = Customer::searchByQuery($query);
 //    } else if ($index == 'invoices') {
 //      $results = Invoice::searchByQuery($query);
 //    } else if ($index == 'items') {
 //      $results = Item::searchByQuery($query);
 //    } else if ($index == 'item-variants') {
 //      $results = ItemVariant::searchByQuery($query);
 //    }

 //    $collection = collect($results->getItems());

 //    return $collection;
 //  }

 //  public function collect($index, Request $request)
 //  {
 //    // Set index specific variables
 //    if ($index == 'catalogs') {
 //      $collection = Catalog::all();
 //    } else if ($index == 'customers') {
 //      $collection = Customer::all();
 //    } else if ($index == 'invoices') {
 //      $collection = Invoice::all();
 //    } else if ($index == 'invoice-items') {
 //      $collection = InvoiceItem::all();
 //    } else if ($index == 'items') {
 //      $collection = Item::all();
 //    } else if ($index == 'item-variants') {
 //      $collection = ItemVariant::all();
 //    } else if ($index == 'pages') {
 //      $collection = Page::all();
 //    } else if ($index == 'users') {
 //      $collection = User::all();
 //    } else {
 //      return response()->json(['$index' => ['Chunking index was not found.']], 500);
 //    }

 //    return $this->chunk($index, $collection, $request);
 //  }

  // static public function searchTags($tags, $page = 1, $limit = 15) {
  //   $query = array();  
  //   $query['bool']['must']['term']['in_stock'] = true; 
  //   if (count($tags) > 0) {
  //     $query['bool']['filter']['terms']['tags'] = $tags;
  //   }
  //   $sort = [[ 'id' => 'desc' ]];
  //   $items = Item::searchByQuery($query, null, null, $limit, $limit * ($page - 1), $sort);

  //   $return = [];
  //   $count = $items->totalHits();
  //   $pages = ceil($count / $limit);
  //   // return $pages;

  //   $return['items'] = array();
  //   $return['count'] = $count;
  //   $return['pages'] = $pages;
  //   $return['page'] = $page;
  //   $return['limit'] = $limit;

  //   foreach ($items->getHits()['hits'] as $hit) {
  //     array_push($return['items'], $hit['_source']);
  //   }
    
  //   return $return;
  // }
}