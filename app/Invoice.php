<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
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
   * An item can have many items
   */
  public function items()
  {
      return $this->hasMany('App\InvoiceItem');
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
}
