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
    $in_stock = false;

    $variants = $this->variants;
    foreach ($variants as $variant) {
      $variant['stock'] = $variant['stock'] - $variant['store_reserve'];
      if ($variant['infinite'] || $variant['stock'] > 0) {
        $in_stock = true;
      }
      unset($variant['store_reserve']);
      unset($variant['sold']);
      unset($variant['in_cart']); // TODO, this stays in results
      unset($variant['created_at']);
      unset($variant['updated_at']);
    }

    $type_info = $this->type_info;

    return array(
      'id' => $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'tags' => explode(',', $this->tags),
      'images' => $this->images,
      'type_info' => $this->type_info,
      'variants' => $variants,
      'in_stock' => $in_stock,
      'updated' => $this->updated_at->getTimestamp(),
    );
  }
}
