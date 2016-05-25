<?php

namespace App\Http\Requests\Offers;

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
			'name' 									=> 'required',
			'type' 									=> 'required',
			'public' 								=> 'boolean',
			'items.*.name' 					=> 'required_with:items[1]',
			'items.*.type' 					=> 'required',
			'items.*.public' 				=> 'boolean',
			'items.*.x' 						=> 'numeric',
			'items.*.y' 						=> 'numeric',
			'items.*.z' 						=> 'numeric',
			'items.*.weight' 				=> 'numeric',
			'items.*.shipping_cost' => 'integer',
			'items.*.infinite'			=> 'boolean',
			'items.*.stock'					=> 'integer',
			'items.*.store_reserve'	=> 'integer',
			'items.*.sold'					=> 'integer',
			'items.*.price'					=> 'integer',
		];
	}
}