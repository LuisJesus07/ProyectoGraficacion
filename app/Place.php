<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id', 'geometry_id', 'property_id', 'category_id'
    ];


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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
