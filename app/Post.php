<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
	  'user_id',
	  'percent_complete',
	  'name',
	  'description',
	  'done',
	  'slug',
	  "post_content",
	  "objective_id"
	];

	public function User() {
      return $this->belongsTo('App\User');
    }

    public function PostSkill() {
        return $this->hasMany('App\PostSkill');
    }

	public function Objective() {
		return $this->belongsTo('App\Objective');
	}
}
