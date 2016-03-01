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

class ItemsController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
