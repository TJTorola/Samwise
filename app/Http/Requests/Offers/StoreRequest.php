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
			'items.*.name' 					=> 'required',
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

// return {
// 	offer: {
// 		id: null,
// 		name: '',
// 		type: 'auto',
// 		public: 1,
// 		description: '',
// 		tags: '',
// 		items: [
// 			{
// 				id: null,
// 				name: '',
// 				type: 'auto',
// 				public: 1,
// 				x: '',
// 				y: '',
// 				z: '',
// 				weight: '',
// 				shipping_cost: '',
// 				location: '',
// 				unit: 'Unit',
// 				infinite: false,
// 				stock: 0,
// 				store_reserve: 0,
// 				sold: 0,
// 				price: 0
// 			}
// 		],
// 		pictures: [],
// 		deleted_pictures: [],
// 		deleted_items: []
// 	}
// }
