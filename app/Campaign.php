<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  protected $fillable = [
    'user_id',
    'percent_complete',
    'name',
    'description',
    'done',
    'slug'
  ];

  public function Mission() {
    return $this->hasMany('App\Mission');
  }

  public function User() {
    return $this->belongsTo('App\User');
  }
}
