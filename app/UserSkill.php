<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
	public function Skill() {
      return $this->belongsTo('App\Skill');
    }
}
