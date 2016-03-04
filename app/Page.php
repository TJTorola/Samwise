<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
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
   * A page belongs to one parent page
   */
  public function parent()
  {
    return $this->belongsTo('Page', 'parent_id');
  }

  /**
   * A page can have many children
   */
  public function children()
  {
    return $this->hasMany('Page', 'parent_id');
  }

  /**
   * Retrieve the prev item
   */
  public function getPrevAttribute()
  {
    $prev_id = Page::where('id', '<', $this->id)->max('id');
    if ($prev_id == null) {
      $prev_id = Page::all()->max('id');
    }
    return "/page/$prev_id";
  }

  /**
   * Retrieve the next item
   */
  public function getNextAttribute()
  {
    $next_id = Page::where('id', '>', $this->id)->min('id');
    if ($next_id == null) {
      $next_id = Page::all()->min('id');
    }
    return "/page/$next_id";
  }
}
