<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{

    protected $fillable = [
    	'user_id', 'description', 'active'
    ];
}
