<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Users\Index;

use JWTAuth;

class UsersController extends Controller
{
	public function index(Index $request)
	{
		return 'here';
	}

	public function show($user)
	{
		return $user;
	}

	public function self()
	{
    return JWTAuth::parseToken()->toUser();
	}
}
