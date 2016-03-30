<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

class Customer extends Model
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
  protected $guarded = ['id', 'created_at', 'updated_at', 'prev', 'next'];

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
    $prev_id = Customer::where('id', '<', $this->id)->max('id');
    if ($prev_id == null) {
      $prev_id = Customer::all()->max('id');
    }
    return "/customer/$prev_id";
  }

  /**
   * Retrieve the next item
   */
  public function getNextAttribute()
  {
    $next_id = Customer::where('id', '>', $this->id)->min('id');
    if ($next_id == null) {
      $next_id = Customer::all()->min('id');
    }
    return "/customer/$next_id";
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
  //
  // }
}
