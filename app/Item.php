<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;
use DB;

class Item extends Model
{
	public static function saveMany($items, $offer_id)
	{
		foreach ($items as $item_array) {
			$item = self::findOrFail($item_array['id']);
			$item_array['type_info'] = self::extractTypeInfo($item_array);
			$item->update($item_array);
		}
	}

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
	protected $appends = ['next', 'prev','full_name'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'infinite' => 'boolean',
		'type_info' => 'array',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'price',
		'unit',
		'stock',
		'infinite',
		'store_reserve',
		'weight',
		'x',
		'y',
		'z',
		'location',
		'type_info'
	];

	/*
	|--------------------------------------------------------------------------
	| Eloquent Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * An item belongs to one offer
	 */
	public function offer()
	{
			return $this->belongsTo('App\Offer');
	}

	/*
	|--------------------------------------------------------------------------
	| Computed Properties
	|--------------------------------------------------------------------------
	*/

	/**
	 * Retrieve the prev item
	 */
	public function getPrevAttribute()
	{
		$prev_id = Item::where('id', '<', $this->id)->max('id');
		if ($prev_id == null) {
			$prev_id = Item::all()->max('id');
		}
		return "/item/$prev_id";
	}

	/**
	 * Retrieve the next item
	 */
	public function getNextAttribute()
	{
		$next_id = Item::where('id', '>', $this->id)->min('id');
		if ($next_id == null) {
			$next_id = Item::all()->min('id');
		}
		return "/item/$next_id";
	}

	/**
	 * Retrieve the full name, including parent offer name
	 */
	public function getFullNameAttribute()
	{
		$name = DB::table('offers')->where('id', $this->offer_id)->pluck('name')[0];
		if ($this->name) {
			return $name." - ".$this->name;
		} else {
			return $name;
		}
	}

	/**
	 * Retrieve the full name, including parent offer name
	 */
	public function getFullNewlineNameAttribute()
	{
		$name = DB::table('offers')->where('id', $this->offer_id)->pluck('name')[0];
		if ($this->name) {
			return $name."\n&nbsp;&nbsp;&nbsp;&nbsp;- ".$this->name;
		} else {
			return $name;
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Static Functions
	|--------------------------------------------------------------------------
	*/

	static public function extractTypeInfo($item) 
	{
		$type = $item['type'];
		$schema = config("samwise.type_schema.item.$type");

		$type_info = [];
		foreach ($schema as $field) {
			if (isset($item[$field['name']])) {
				$type_info[$field['name']] = $item[$field['name']];
			} else {
				$type_info[$field['name']] = '';
			}
		}

		return json_encode($type_info);
	}

	/*
	|--------------------------------------------------------------------------
	| Return Arrays
	|--------------------------------------------------------------------------
	*/
	public function toPrivateArray()
	{
		$item = $this->toArray();

		// place type info fields directly under root
		if ($this->type_info != '') {
			$type_info = json_decode($this->type_info);
			foreach ($type_info as $type_field => $value) {
				$item[$type_field] = $value;
			}
		}

		return $item;
	}

	public function toPublicArray()
	{
		$item = $this->toPrivateArray();
		// TODO, strip private attributes

		return $item;
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
	// protected $mappingProperties = array();

	/**
	 * Modify index model as it goes into ES
	 */
	// function getIndexDocumentData()
	// {
	//   return $this->publicArray();
	// }
}
