<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
	 protected $fillable = [
       'user_id',
       'description',
       'follow_id',
    ];
    protected $primaryKey = 'follow_id';

    public function User() {
      return $this->belongsTo('App\User', 'follow_id');
    }

    public function FollowingUser() {
      return $this->belongsTo('App\User', 'user_id');
    }
}
