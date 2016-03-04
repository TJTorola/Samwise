<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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
  protected $casts = [
      'type_info' => 'array',
  ];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at', 'prev', 'next'];

  /**
   * An item can have many variants
   */
  public function variants()
  {
      return $this->hasMany('App\ItemVariant');
  }

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
}
