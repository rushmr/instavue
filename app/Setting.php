<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //

    public function project(){
    	return $this->belongsTo('App\Project');
    }
}
