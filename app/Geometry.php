<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geometry extends Model
{
    //

    public function place()
    {
    	return $this->belongsTo(Place::class);
    }
}
