<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Settings\StoreRequest;
use App\Http\Requests\Settings\UpdateRequest;

class SettingsController extends Controller
{
	/**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return config('samwise');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($setting)
  {
    $setting = implode('.', explode('/', $setting));
    return config("samwise.$setting");
  }
}
