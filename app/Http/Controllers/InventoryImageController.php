<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InventoryImageController extends Controller
{
	/**
	 * Retrieve all of the inventory images availible
	 * GET /storage/images
	 * @return array
	 */
	public function getImages()
	{
		return [];
	}

	/**
	 * Get all inventory images for a given item id
	 * GET /storage/images/{item_id}
	 * @return array
	 */
	public function getItemImages($item_id)
	{
		return [];
	}
}
