<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Catalog;

class TagsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$catalogs = Catalog::all();
		$tag_array = [];
		foreach ($catalogs as $catalog) {
			$tags = explode(',', $catalog['tags']);
			foreach ($tags as $tag) {
				if ($tag != "" && !in_array($tag, $tag_array)) {
					$tag_array[] = $tag;
				}
			}
		}

		return $tag_array;
	}
}
