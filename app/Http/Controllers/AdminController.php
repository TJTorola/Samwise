<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class AdminController extends Controller
{
	/**
	 * Return the correct view for someone trying to
	 * access the admin panel.
	 */
	public function home()
	{
		return view('admin');
	}
}
