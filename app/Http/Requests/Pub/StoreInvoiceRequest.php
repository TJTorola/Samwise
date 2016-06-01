<?php

namespace App\Http\Requests\Pub;

use App\Http\Requests\Request;

class StoreInvoiceRequest extends Request
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
			'cart' 												=> 'valid_cart:in_stock',
			'email' 											=> 'required|email',
			'confirm_email'								=> 'required|same:email',
			'seperate_billing' 						=> 'required|boolean',
			'phone_preferred'							=> 'boolean',
			'shipping_address.first_name' => 'required',
			'shipping_address.last_name' 	=> 'required',
			'shipping_address.city' 			=> 'required',
			'shipping_address.state' 			=> 'required',
			'shipping_address.zip' 				=> 'required',
			'shipping_address.street' 		=> 'required',
			'billing_address.first_name' 	=> 'required_if:seperate_billing,true',
			'billing_address.last_name' 	=> 'required_if:seperate_billing,true',
			'billing_address.city' 				=> 'required_if:seperate_billing,true',
			'billing_address.state' 			=> 'required_if:seperate_billing,true',
			'billing_address.zip' 				=> 'required_if:seperate_billing,true',
			'billing_address.street' 			=> 'required_if:seperate_billing,true',
		];
	}
}
