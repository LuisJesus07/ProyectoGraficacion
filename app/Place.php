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

    public function properties()
    {
    	return $this->hasOne(Property::class);
    }

    public function geometry()
    {
    	return $this->hasOne(Geometry::class);
    }
}
