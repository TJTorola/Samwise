<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTodo extends Model
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
  protected $guarded = ['id', 'created_at', 'updated_at'];

  /**
   * A user todo belongs to one user
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
