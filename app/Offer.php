<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

class Offer extends Model
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
	protected $appends = ['next', 'prev', 'infinite', 'price_high', 'price_low', 'sold', 'stock'];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at', 'prev', 'next'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
			'type_info' => 'array',
	];

	/*
	|--------------------------------------------------------------------------
	| Eloquent Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * An offer can have many items
	 */
	public function items()
	{
		return $this->hasMany('App\Item');
	}

	/*
	|--------------------------------------------------------------------------
	| Computed Properties
	|--------------------------------------------------------------------------
	*/

	/**
	 * Retrieve the prev offer
	 */
	public function getPrevAttribute()
	{
		$prev_id = Offer::where('id', '<', $this->id)->max('id');
		if ($prev_id == null) {
			$prev_id = Offer::all()->max('id');
		}
		return "/offer/$prev_id";
	}

	/**
	 * Retrieve the next offer
	 */
	public function getNextAttribute()
	{
		$next_id = Offer::where('id', '>', $this->id)->min('id');
		if ($next_id == null) {
			$next_id = Offer::all()->min('id');
		}
		return "/offer/$next_id";
	}

	public function getInfiniteAttribute()
	{
		foreach ($this->items as $item) {
			if ($item['infinite']) {
				return true;
			}
		}

		return false;
	}

	public function getPriceHighAttribute()
	{
		$high = null;
		foreach ($this->items as $item) {
			if ($high == null || $item['price'] > $high) {
				$high = $item['price'];
			}
		}

		return $high;
	}

	public function getPriceLowAttribute()
	{
		$low = null;
		foreach ($this->items as $item) {
			if ($low == null || $item['price'] < $low) {
				$low = $item['price'];
			}
		}

		return $low;
	}

	public function getSoldAttribute()
	{
		$sold = 0;
		foreach ($this->items as $item) {
			$sold += $item['sold'];
		}

		return $sold;
	}

	public function getStockAttribute()
	{
		if ($this->infinite) {
			return PHP_INT_MAX;
		}

		$stock = 0;
		foreach ($this->items as $item) {
			$stock += $item['stock'];
		}

		return $stock;
	}

	/*
	|--------------------------------------------------------------------------
	| Return Arrays
	|--------------------------------------------------------------------------
	*/
	public function toPrivateArray($manager = false)
	{
		$offer = $this->toArray();

		// place type info fields directly under root
		$type_info = json_decode($this->type_info);
		foreach ($type_info as $type_field => $value) {
			$offer[$type_field] = $value;
		}

		$offer['items'] = $this->items;

		return $offer;
	}

	public function toPublicArray()
	{
		$offer = $this->toPrivateArray();
		// TODO, strip private attributes

		return $offer;
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

		
	protected $mappingProperties = array(
		'tags' => [
			'type' => 'string',
			'index' => 'not_analyzed',
		],
		'name' => [
			'type' => 'string',
			'index' => 'not_analyzed'
		],
		'infinite' => [
			'type' => 'boolean'
		]
	);

	/**
	 * Modify index model as it goes into ES
	 */
	function getIndexDocumentData()
	{
		return $this->toCustomArray();
	}
}
