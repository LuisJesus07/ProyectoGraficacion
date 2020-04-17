<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geometry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitud', 'longitud'
    ];

    public function place()
    {
    	return $this->belongsTo(Place::class);
    }
}
