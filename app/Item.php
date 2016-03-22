<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

class Item extends Model
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
   * An item can have many variants
   */
  public function variants()
  {
    return $this->hasMany('App\ItemVariant');
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

  /*
  |--------------------------------------------------------------------------
  | Return Arrays
  |--------------------------------------------------------------------------
  */
  public function publicArray()
  {
    $variants = $this->variants;

    $stock = 0;
    $infinite = false;

    $price_low = $variants[0]['price'];
    $price_high = $price_low;

    foreach ($variants as $variant) {
      $variant['stock'] = $variant['stock'] - $variant['store_reserve'];

      if ($variant['infinite']) {
        $infinite = true;
      }
      $stock += $variant['stock'];

      if ($variant['price'] < $price_low) {
        $price_low = $variant['price'];
      }

      if ($variant['price'] > $price_high) {
        $price_high = $variant['price'];
      }

      unset($variant['store_reserve']);
      unset($variant['sold']);
      unset($variant['created_at']);
      unset($variant['updated_at']);
    }

    $return = $this->toArray();

    unset($return['type_info']);
    $return['tags'] = explode(',', $return['tags']);
    $return['price_high'] = $price_high;
    $return['price_low'] = $price_low;
    $return['stock'] = $stock;
    $return['infinite'] = $infinite;

    $type_info = json_decode($this->type_info);
    foreach ($type_info as $type_field => $value) {
      $return[$type_field] = $value;
    }

    return $return;
  }

  public function privateArray()
  {
    $in_stock = false;

    $variants = $this->variants;
    foreach ($variants as $variant) {
      if ($variant['infinite'] || $variant['stock'] > 0) {
        $in_stock = true;
      }
    }

    $return = $this->toArray();

    unset($return['type_info']);
    $return['tags'] = explode(',', $return['tags']);

    $type_info = json_decode($this->type_info);
    foreach ($type_info as $type_field => $value) {
      $return[$type_field] = $value;
    }

    return $return;
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
  );

  /**
   * Modify index model as it goes into ES
   */
  function getIndexDocumentData()
  {
    return $this->publicArray();
  }
}
