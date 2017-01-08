<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
  protected $fillable = [
    'campaign_id',
    'percent_complete',
    'name',
    'description',
    'done',
    'mission_slug'
  ];

  public function Campaign() {
    return $this->belongsTo('App\Campaign');
  }

  public function Objective() {
    return $this->hasMany('App\Objective');
  }

}
