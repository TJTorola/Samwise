<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
	public function login(Request $request) 
	{
		$credentials = $request->only('email', 'password');

    if (! $token = JWTAuth::attempt($credentials)) {
      return response()->json('Username and Password do not match our records.', 401);
    }

    // if no errors are encountered we can return a JWT
    return compact('token');
	}

	public function logout()
	{
		
	}

	public function register()
	{

	}	
}