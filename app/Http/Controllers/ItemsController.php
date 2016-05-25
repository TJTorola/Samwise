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

use App\Search;
use App\Item;

class ItemsController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, Search $search)
  {
    return $search->query('items', $request);
  }

  /**
   * Display the specified public version of the resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Item::findOrFail($id)->toArray();
  }

  /**
   * Display the specified private version of the resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function showAdmin($id)
  {
    return Item::findOrFail($id)->privateArray();
  }
}
