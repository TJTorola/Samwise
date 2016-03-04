<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
  /**
   * Get the validation rules that apply to all requests.
   *
   * @return array
   */
  public function rules()
  {
    return [
      '_startAt' => 'integer|min:0',
      '_limit' => 'integer|min:0',
    ];
  }
}
