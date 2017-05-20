<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostSkill extends Model
{
	protected $fillable = [
		'skill_id',
		'post_id',
		'created_at',
		'updated_at'
	];

	public function Post() {
		return $this->belongsTo('App\Post');
	}

	public function Skill() {
		return $this->belongsTo('App\Skill');
	}
}
