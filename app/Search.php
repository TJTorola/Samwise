<?php

namespace App;

use Illuminate\Http\Request;
use App\Http\Requests;

use Validator;

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
   * Returns a collection of models from the provided index using params from
   * a provided request. This only uses default laravel collection functions
   * as a alternative to query() which uses elastic search.
   *
   * @param  string $index
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function chunk($index, Request $request)
  {
  	// Set index specific variables
  	if ($index == 'catalogs') {
  		$collection = Catalog::all();
  		$base_href = '/catalogs';
  	} else if ($index == 'customers') {
  		$collection = Customer::all();
  		$base_href = '/customers';
  	} else if ($index == 'invoices') {
  		$collection = Invoice::all();
  		$base_href = '/invoices';
  	} else if ($index == 'invoice-items') {
  		$collection = InvoiceItem::all();
  		$base_href = '/invoice-items';
  	} else if ($index == 'items') {
  		$collection = Item::all();
  		$base_href = '/items';
  	} else if ($index == 'item-variants') {
  		$collection = ItemVariant::all();
  		$base_href = '/item-variants';
  	} else if ($index == 'pages') {
  		$collection = Page::all();
  		$base_href = '/pages';
  	} else if ($index == 'users') {
  		$collection = User::all();
  		$base_href = '/users';
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

  	// Set the collection slice params
    $page = 0;
    $limit    = env('STORE_COLLECTION_LIMIT', 25);
    if ($request->has('_page')) {
      $page = $request->_page;
    }
    if ($request->has('_limit')) {
      $limit = $request->_limit;
    }

    // set basic collection info
    $length = $collection->count();
    $collection = $collection->chunk($limit);
    $pages = count($collection);

    // set the current, next, and prev hrefs

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

    // Set this_href
    if (!$request->has('_limit') && $page == 0) { // Default limit & Default starting point
      $href = "$base_href";
    } else if (!$request->has('_limit') && $page != 0) { // Default limit & set starting point
      $href = "$base_href?_page=$page";
    } else if ($request->has('_limit') && $page == 0) { // Set limit & default starting point
      $href = "$base_href?_limit=$limit";
    } else if ($request->has('_limit') && $page != 0) { // Set limit & set starting point
      $href = "$base_href?_page=$page&_limit=$limit";
    }

    // Set next_href
    if (!$request->has('_limit') && $next_page == 0) { // Default limit & Default starting point
      $next_href = "$base_href";
    } else if (!$request->has('_limit') && $next_page != 0) { // Default limit & set starting point
      $next_href = "$base_href?_page=$next_page";
    } else if ($request->has('_limit') && $next_page == 0) { // Set limit & default starting point
      $next_href = "$base_href?_limit=$limit";
    } else if ($request->has('_limit') && $next_page != 0) { // Set limit & set starting point
      $next_href = "$base_href?_page=$next_page&_limit=$limit";
    }

    // Set prev_href
    if (!$request->has('_limit') && $prev_page == 0) { // Default limit & Default starting point
      $prev_href = "$base_href";
    } else if (!$request->has('_limit') && $prev_page != 0) { // Default limit & set starting point
      $prev_href = "$base_href?_page=$prev_page";
    } else if ($request->has('_limit') && $prev_page == 0) { // Set limit & default starting point
      $prev_href = "$base_href?_limit=$limit";
    } else if ($request->has('_limit') && $prev_page != 0) { // Set limit & set starting point
      $prev_href = "$base_href?_page=$prev_page&_limit=$limit";
    }

    // Check if page exists, if not, throw error
    if (!isset($collection[$page])) {
      return response()->json(['_page' => ['Page does not exist for the set limit.']], 422);
    } else {
      $body = $collection[$page];
    }

    return [
      '_page' => $page,
      '_limit' => $limit,
      'href' => $href,
      'prev' => $prev_href,
      'next' => $next_href,
      'length' => $length,
      'pages' => $pages,
      'body' => $body
    ];
  }

  public function query($index, Request $request)
  {
    return 'Houston, we have ignition';
  }
}