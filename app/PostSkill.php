<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostSkill extends Model
{
	public function Post() {
		return $this->hasOne('App\Post');
	}

	public function Skill() {
		return $this->belongsTo('App\Skill');
	}
}
