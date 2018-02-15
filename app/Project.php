<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'login', 'password', 'feed', 'tags'];

    public function settings(){
    	return $this->hasOne('App\Setting');
    }

    public function posts(){
    	return $this->hasMany('App\Post');
    }
}
