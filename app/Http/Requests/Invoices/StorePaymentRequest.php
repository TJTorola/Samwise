<?php

namespace App\Http\Requests\Invoices;

use App\Http\Requests\Request;

class StorePaymentRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'token'		=> 'required',
			'amount'	=> 'integer|required'
		];
	}
}
