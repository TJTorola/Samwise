<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
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
   * An variant belongs to one invoice
   */
  public function invoice()
  {
      return $this->belongsTo('App\Invoice');
  }

  /**
   * Retrieve the prev item
   */
  public function getPrevAttribute()
  {
    $prev_id = InvoiceItem::where('id', '<', $this->id)->max('id');
    if ($prev_id == null) {
      $prev_id = InvoiceItem::all()->max('id');
    }
    return "/invoice-item/$prev_id";
  }

  /**
   * Retrieve the next item
   */
  public function getNextAttribute()
  {
    $next_id = InvoiceItem::where('id', '>', $this->id)->min('id');
    if ($next_id == null) {
      $next_id = InvoiceItem::all()->min('id');
    }
    return "/invoice-item/$next_id";
  }
}
