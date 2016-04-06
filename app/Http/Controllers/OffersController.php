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
use App\Offer;

class OffersController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, Search $search)
  {
    return $search->query('offers', $request);
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
   * Display the specified public version of the resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return Offer::findOrFail($id)->toPublicArray();
  }

  /**
   * Display the specified private version of the resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function showAdmin($id)
  {
    return Offer::findOrFail($id)->toPrivateArray();
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

	public function indexItems()
	{

	}

	public function storeItem(StoreVariantRequest $request) // TODO CHANGE TO StoreItemRequest
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
