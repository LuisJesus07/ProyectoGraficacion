<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //


    public function city()
    {
    	return $this->belongsTo(City::class);
    }

    public function property()
    {
    	return $this->belongsTo(Property::class);
    }

    public function geometry()
    {
    	return $this->belongsTo(Geometry::class);
    }
}
