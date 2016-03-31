<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Catalogs\StoreRequest;
use App\Http\Requests\Catalogs\UpdateRequest;
use App\Http\Requests\Catalogs\UpdateCollectionRequest;

use App\Catalog;

class CatalogsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		return Catalog::orderBy('sorting')->get();
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

	public function updateCollection(UpdateCollectionRequest $request)
	{
		// Check each catalog to see if it has a unique name
		$nameArray = [];
		foreach ($request->catalogs as $catalog) {
			array_push($nameArray, makeSlug($catalog['name']));
		}
		$names = ','.implode(',,', $nameArray).',';
		foreach ($request->catalogs as $catalog) {
			if (substr_count($names, ",".makeSlug($catalog['name']).",") > 1) {
				return response()->json(['Catalog Name Duplication' => ['Each catalog name must be unique']], 422);
			}
		}

		// delete catalogs in deletedCatalogs
		foreach ($request->deletedCatalogs as $catalog) {
			Catalog::destroy($catalog['id']);
		}

		foreach ($request->catalogs as $catalog) {
			if (isset($catalog['id'])) {
				// update exisiting catalogs
				Catalog::find($catalog['id'])->update($catalog);
			} else {
				// store new catalogs
				Catalog::create($catalog);
			}
		}

		return json_encode($request->all());
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
}
