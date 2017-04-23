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
	  'slug'
	];

	public function User() {
      return $this->belongsTo('App\User');
    }

    // public function UserSkills() {
    //   return $this->hasMany('App\UserSkills');
    // }
	//
    public function PostSkill() {
        return $this->hasMany('App\PostSkill');
    }
}
