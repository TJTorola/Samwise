<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

class Invoice extends Model
{
	/*
	|--------------------------------------------------------------------------
	| Eloquent Configuration
	|--------------------------------------------------------------------------
	*/

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['next', 'prev', 'status', 'billing_address', 'shipping_address', 'cart', 'subtotal'];

	/**
	 * The attributes excluded from the model's array form.
	 *
	 * @var array
	 */
	protected $hidden = [
		// 'company',
		// 'country',
		// 'state',
		// 'zip',
		// 'city',
		// 'street_address_first',
		// 'street_address_second',
		// 'apt',
		// 'billing_first_name',
		// 'billing_last_name',
		// 'billing_company',
		// 'billing_country',
		// 'billing_state',
		// 'billing_zip',
		// 'billing_city',
		// 'billing_street_address_first',
		// 'billing_street_address_second',
		// 'billing_apt',
		// 'shipping_cost',
		// 'items'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [
		'id', 
		'created_at', 
		'updated_at', 
		'prev', 
		'next', 
		'subtotal', 
		'status', 
		'amount_paid', 
		'due', 
		'billing_address', 
		'shipping_address',
		'cart'
	];

	/*
	|--------------------------------------------------------------------------
	| Eloquent Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * An invoice can have many items
	 */
	public function items()
	{
		return $this->hasMany('App\InvoiceItem');
	}

	/**
	 * An invoice can have many payments
	 */
	public function payments()
	{
		return $this->hasMany('App\Payment');
	}

	/*
	|--------------------------------------------------------------------------
	| Computed Properties
	|--------------------------------------------------------------------------
	*/

	/**
	 * Return the amount left due on the invoice
	 */
	public function getDueAttribute()
	{
		$total = $this->subtotal + $this->shipping_cost;

		return $total - $this->amount_paid;
	}

	/**
	 * Retrieve the prev item
	 */
	public function getPrevAttribute()
	{
		$prev_id = Invoice::where('id', '<', $this->id)->max('id');
		if ($prev_id == null) {
			$prev_id = Invoice::all()->max('id');
		}
		return "/invoice/$prev_id";
	}

	/**
	 * Retrieve the next item
	 */
	public function getNextAttribute()
	{
		$next_id = Invoice::where('id', '>', $this->id)->min('id');
		if ($next_id == null) {
			$next_id = Invoice::all()->min('id');
		}
		return "/invoice/$next_id";
	}

	/**
	 * Bundle the shipping address into one hash table
	 */
	public function getShippingAddressAttribute()
	{
		return [
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'company' => $this->company,
			'country' => $this->country,
			'state' => $this->state,
			'zip' => $this->zip,
			'city' => $this->city,
			'street' => $this->street_address_first,
			'street_second' => $this->street_address_second,
			'apt' => $this->apt
		];
	}

	/**
	 * Bundle the billing address into one hash table
	 */
	public function getBillingAddressAttribute()
	{
		return [
			'first_name' => $this->billing_first_name,
			'last_name' => $this->billing_last_name,
			'company' => $this->billing_company,
			'country' => $this->billing_country,
			'state' => $this->billing_state,
			'zip' => $this->billing_zip,
			'city' => $this->billing_city,
			'street' => $this->billing_street_address_first,
			'street_second' => $this->billing_street_address_second,
			'apt' => $this->billing_apt
		];
	}

	/**
	 * Bundle the cart items, and pertinant info into one hash table
	 */
	public function getCartAttribute()
	{
		return [
			'subtotal' => $this->subtotal,
			'shipping_cost' => $this->shipping_cost,
			'paid' => $this->amount_paid,
			'due' => $this->due,
			'items' => $this->items
		];
	}


	/**
	 * Return the status of the invoice
	 */
	public function getStatusAttribute()
	{
		if ($this->billed && $this->paid && $this->shipped) {
			return 'completed';
		} else if ($this->billed && $this->paid) {
			return 'paid';
		} else if ($this->billed) {
			return 'billed';
		} else {
			return 'new';
		}
	}

	/**
	 * Return the amount that has been paid on the invoice
	 */
	public function getAmountPaidAttribute()
	{
		$paid = 0;
		foreach ($this->payments as $payment) {
			$paid += $payment['amount'];
		}

		return $paid;
	}

	/**
	 * Calculate the subtotal of the invoice
	 */
	public function getSubtotalAttribute()
	{
		$subtotal = 0;
		foreach ($this->items as $item) {
			$subtotal += $item['price'] * $item['count'];
		}

		return $subtotal;
	}

	/*
	|--------------------------------------------------------------------------
	| Elastiquent Configuration
	|--------------------------------------------------------------------------
	*/
	use ElasticquentTrait;

	/**
	 * Set mapping properties
	 */
	protected $mappingProperties = [
		'email' => [
			'type' => 'string',
			'analyzer' => 'email',
		]
	];

	/**
	 * The elasticsearch settings.
	 *
	 * @var array
	 */
	protected $indexSettings = [
		"analysis" => [
			"filter" => [
				"email" => [
					"type" => "pattern_capture",
					"preserve_original" => 1,
					"patterns" => [
						"([^@]+)",
						"(\\p[L}+)",
						"(\\d+)",
						"@(.+)",
						"([^-@]+)"
					]
				]
			],
			"analyzer" => [
				"email" => [
					"tokenizer" => "uax_url_email",
					"filter" => [
						"email",
						"lowercase",
						"unique"
					]
				]
			]
		]
	];

	/**
	 * Modify index model as it goes into ES
	 */
	// function getIndexDocumentData()
	// {
	// 	return $this->toArray();
	// }
}
