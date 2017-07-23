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
	// public function user() {
	// 	return $this->belongsTo(User::class);
	// }
	// ^ may become redundant now thread introduced
	public function User() {
		return $this->belongsTo(User::class);
	}

	public function Message() {
		return $this->hasMany('App\Message');
	}
}
