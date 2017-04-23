<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'vip', 'firstLogin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Campaign() {
      return $this->hasMany('App\Campaign');
    }

    public function Follows() {
      return $this->hasMany('App\Follows');
    }

    public function Posts() {
      return $this->hasMany('App\Post');
    }

    public function UserSkill() {
      return $this->hasMany('App\UserSkill');
    }

    public function Skills() {
        return $this->hasMany('App\Skills');
    }

    public function PostSkills() {
        return $this->hasMany('App\PostSkills');
    }
}
