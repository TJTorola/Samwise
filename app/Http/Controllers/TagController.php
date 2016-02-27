<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
	/**
   * Retrieve an array of tags used within items & catalogs
   * GET /static/tags/catalog
   * @return array
   */
	public function getTags()
	{
		return [];
	}

	/**
	 * Retrieve an array of tags used within catalogs alone
	 * GET /static/tags
	 * @return array
	 */
	public function getTagsCatalog()
	{
		return [];
	}

	/**
	 * Retrieve an array of tags used within items alone
	 * GET /static/tags/item
	 * @return array
	 */
	public function getTagsItem()
	{
		return [];
	}
}
