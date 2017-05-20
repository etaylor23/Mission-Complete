<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
	protected $fillable = [
	  "skill_id",
	  "skill_name"
	];

	public function PostSkill() {
	  return $this->hasMany('App\PostSkill');
	}
	public function UserSkill() {
	  return $this->hasMany('App\UserSkill');
	}
}
