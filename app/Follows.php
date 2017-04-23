<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
	// protected $fillable = [
    //   'user_id',
    //   'percent_complete',
    //   'name',
    //   'description',
    //   'done',
    //   'slug'
    // ];
    protected $primaryKey = 'follow_id';

    public function User() {
      return $this->belongsTo('App\User', 'follow_id');
    }
}
