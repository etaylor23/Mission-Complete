<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
	protected $fillable = [
		'user_id',
		'skill_id',
		'objective_id'
	];

	public function Skill() {
      return $this->belongsTo('App\Skill');
    }

	public function Objective() {
		return $this->belongsTo('App\Objective');
	}

	public function User() {
		return $this->belongsTo('App\User');
	}
}
