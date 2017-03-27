<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveComplete extends Model
{
	public $fillable = ['user_id', 'message'];
}
