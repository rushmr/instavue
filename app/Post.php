<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['project_id', 'post_id', 'picture_path', 'text', 'executed'];

    public function project(){
    	return $this->belongsTo('App\Project');
    }
}
