<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Cache\RateLimiter;

use App\User;

class AuthController extends Controller
{
	public function login(LoginRequest $request, RateLimiter $limiter) 
	{
		// Gather Request info
		$email = $request->email;
		$password = $request->password;
		$captcha = $request->captcha;

		// Normalize email
		$email = strtolower($email);

		// Check for brute force attack
		// > 3 failed attempts in a half hour
		$attempts_remaining = $limiter->retriesLeft($email, 3);
		// return response()->json($attempts_remaining, 429);
		if ($attempts_remaining <= 0) {

			// potential brute force attack detected,
			// check for captcha to continue login attempts
			if (!$this->check_captcha($captcha, $request->ip)) {
				// Failed captcha check, return warning and quit
				$note = [
					'type' => 'warning',
					'title' => 'Too Many Attempts',
					'body' => 'Too many attempts on user, supply valid recaptcha key.',
					'timeout' => 3000
				];
				return response()->json(['note' => $note], 429);
			}
		}

		// Attempt login
		if (! $token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
			// Login failed, incrament failed attempts
			$limiter->hit($email, 3, 30);

			// Return failed warning
			$note = [
				'type' => 'warning',
				'title' => 'Invalid Credentials',
				'body' => 'Username and Password do not match our records.',
				'timeout' => 3000
			];
			return response()->json(['note' => $note, 'attempts_remaining' => $attempts_remaining - 1], 400);
		}

		// No errors encountered we can return a JWT
		return compact('token');
	}

	public function logout()
	{
		
	}

	public function register(RegisterRequest $request)
	{
		return User::create([
			'name' => $request->name,
			'email' => strtolower($request->email),
			'password' => bcrypt($request->password),
		]);
	}

	private function check_captcha($captcha, $ip)
	{
		if (!$captcha) {
			return false;
		}

		$secret_key = env('RECAPTCHA_SECRET');

		$request_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha&remoteip=$ip";
		$response = json_decode(file_get_contents($request_url), true);

		return $response['success'];
	}
}