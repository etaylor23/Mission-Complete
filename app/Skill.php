<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
	public function PostSkill() {
	  return $this->hasMany('App\PostSkill');
	}
	public function UserSkill() {
	  return $this->hasMany('App\UserSkill');
	}
}
