<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

class OfferPicture extends Model
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
	protected $appends = [];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/*
	|--------------------------------------------------------------------------
	| Eloquent Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * An picture belogs to an offer
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

	/*
	|--------------------------------------------------------------------------
	| Return Arrays
	|--------------------------------------------------------------------------
	*/
	
}
