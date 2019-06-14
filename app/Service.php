<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    
	public function users(){
		$this->belongsToMany('App\User');
	}

}
