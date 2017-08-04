<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $fillable = [
	  "id",
		"post_id",
		"user_id"
	];

	public function User() {
		return $this->belongsTo(User::class);
	}

	public function Post() {
		return $this->belongsTo('App\Post');
	}

	public function Message() {
		return $this->hasMany('App\Message');
	}
}
