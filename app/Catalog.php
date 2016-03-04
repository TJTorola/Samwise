<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
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
  protected $casts = [];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id', 'created_at', 'updated_at', 'prev', 'next'];

  /**
   * Retrieve the prev item
   */
  public function getPrevAttribute()
  {
    $prev_id = Catalog::where('id', '<', $this->id)->max('id');
    if ($prev_id == null) {
      $prev_id = Catalog::all()->max('id');
    }
    return "/catalog/$prev_id";
  }

  /**
   * Retrieve the next item
   */
  public function getNextAttribute()
  {
    $next_id = Catalog::where('id', '>', $this->id)->min('id');
    if ($next_id == null) {
      $next_id = Catalog::all()->min('id');
    }
    return "/catalog/$next_id";
  }
}
