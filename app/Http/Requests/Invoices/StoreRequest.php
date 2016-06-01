<?php

namespace App\Http\Requests\Invoices;

use App\Http\Requests\Request;

class StoreRequest extends Request
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
			'cart' 												=> 'valid_cart',
			'email' 											=> 'required|email',
			'seperate_billing' 						=> 'required|boolean',
			'shipping_address.first_name' => 'required',
			'shipping_address.last_name' 	=> 'required',
			'shipping_address.first_name' => 'required_if:seperate_billing,true',
			'shipping_address.last_name' 	=> 'required_if:seperate_billing,true',
		];
	}
}
