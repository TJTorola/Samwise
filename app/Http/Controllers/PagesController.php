<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Pages\StoreRequest;
use App\Http\Requests\Pages\UpdateRequest;
use App\Http\Requests\Pages\UpdateCollectionRequest;

// use App\Search;
use App\Page;

class PagesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		return [
			'header' => Page::where('location', 'header')->where('parent_id', null)->orderBy('sorting')->get()->toArray(),
			'footer' => Page::where('location', 'footer')->where('parent_id', null)->orderBy('sorting')->get()->toArray(),
			'hidden' => Page::where('location', 'hidden')->where('parent_id', null)->orderBy('sorting')->get()->toArray()
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

	public function updateCollection(UpdateCollectionRequest $request)
	{
		// Make sure that each page, with the same parent_id has a unique name
		// start by assemblying the pages into an array grouped by name
		$familys = array();
		$familys['null'] = [];
		foreach ($request->pages as $page) {
			if ($page['parent_id'] == null) {
				$familys['null'][] = $page['name'];
			} else {
				if (!isset($familys[$page['parent_id']])) {
					$familys[$page['parent_id']] = [];
				}
				$familys[$page['parent_id']][] = $page['name'];
			}
		}

		// then go through the named array and check for duplicates
		foreach ($familys as $family) {
			$test = [];
			foreach ($family as $name) {
				$name = makeSlug($name);
				if (in_array($name, $test)) {
					return response()->json(['Page Name Duplication' => ['Each page name must be unique']], 422);
				} else {
					$test[] = $name;
				}
			}
		}

		// delete pages in delete
		foreach ($request->delete as $page_id) {
			Page::destroy($page_id);
		}

		foreach ($request->pages as $page) {
			if (isset($page['id'])) {
				// update exisiting pages
				Page::find($page['id'])->update($page);
			} else {
				// store new pages
				Page::create($page);
			}
		}

		return $request->all();
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
