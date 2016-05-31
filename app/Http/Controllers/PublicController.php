<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App;
use App\Offer;

class PublicController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function offer($id) {
		$offer = Offer::findOrFail($id);
		if ($offer->public) {
			return $offer->toPublicArray();
		}
		App::abort(404);
	}
}
