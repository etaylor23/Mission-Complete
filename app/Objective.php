<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{

    protected $fillable = [
      "name",
      "description",
      "done",
      "mission_id",
      "objective_slug",
      "percent_complete"
    ];

    public function Mission() {
      return $this->belongsTo('App\Mission');
    }

    public function Post() {
        return $this->hasOne('App\Post');
    }

    public function UserSkill() {
        return $this->hasMany('App\UserSkill');
    }
}
