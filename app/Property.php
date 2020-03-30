<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    

    public function place()
    {
    	return $this->belongsTo(Place::class);
    }
}
