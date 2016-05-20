<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
  protected $appends = ['gravitar'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'admin',
    'catalogs',
    'customers',
    'inventory',
    'invoices',
    'pages'
  ];

  /**
   * The attributes that should be casted to native types.
   *
   * @var array
   */
  protected $casts = [
    'root' => 'boolean',
    'admin' => 'boolean',
    'catalogs' => 'boolean',
    'customers' => 'boolean',
    'inventory' => 'boolean',
    'invoices' => 'boolean',
    'pages' => 'boolean'
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token'
  ];

  /*
  |--------------------------------------------------------------------------
  | Eloquent Relations
  |--------------------------------------------------------------------------
  */

  /**
   * An user can have many things to do
   */
  public function todos()
  {
   return $this->hasMany('App\Todo');
  }

  /*
  |--------------------------------------------------------------------------
  | Computed Properties
  |--------------------------------------------------------------------------
  */

  /**
   * Gravitar is a service which hosts universal avitars and
   * automatically generates them as well.
   */
  public function getGravitarAttribute()
  {
   $hash = md5(strtolower(trim($this->email)));
   return "https://www.gravatar.com/avatar/$hash?d=identicon&s=90";
  }
}
