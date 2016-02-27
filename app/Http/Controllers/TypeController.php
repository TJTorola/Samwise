<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
	/**
	 * Get the type array for a given type
	 * GET /static/type/{type}
	 * @return array
	 */
	public function getType($type) {
		return [];
	}

	/**
	 * Get an array of the availible types for the set skin
	 * GET /static/types
	 * @return array
	 */
	public function getTypes() {
		return [];
	}
}
