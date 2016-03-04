<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Catalogs\StoreRequest;
use App\Http\Requests\Catalogs\UpdateRequest;
use App\Http\Requests\Catalogs\StoreVariantRequest;
use App\Http\Requests\Catalogs\StoreImageRequest;
use App\Http\Requests\Catalogs\UpdateImageRequest;

use App\Item;

class ItemsController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
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
    $collection = Item::all();
    $length = $collection->count();
    $collection = $collection->chunk($limit);
    $pages = count($collection);

    // set the current, next, and prev hrefs
    $base_href = '/items';

    // calculate next starting point
    $next_page = $page + 1;
    if ($next_page >= $pages) {
      $next_page = 0;
    }

    // calculate prev starting point
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
      return response()->json('Page does not exist for the set limit.', 422);
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
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

	public function indexVariants()
	{

	}

	public function storeVariant(StoreVariantRequest $request)
	{

	}

	public function indexImages()
	{

	}

	public function storeImage(StoreImageRequest $request)
	{

	}

	public function updateImage(UpdateImageRequest $request)
	{

	}

	public function destroyImage()
	{

	}
}
