<?php

namespace App\Http\Requests\Invoices;

use App\Http\Requests\Request;

class UpdateRequest extends Request
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
			'store_notes' 			=> 'max:255',
			'email' 						=> 'email|max:255',
			'phone' 						=> 'max:255',
			'seperate_billing' 	=> 'boolean',
			'billed' 						=> 'boolean',
			'paid' 							=> 'boolean',
			'shipped' 					=> 'boolean',
			'shipping_cost' 		=> 'integer',
			'subtotal' 					=> 'integer'
		];
	}
}
