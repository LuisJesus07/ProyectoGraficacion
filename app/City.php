<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'url_foto'
    ];


    public function places()
    {
    	return $this->hasMany(Place::class);
    }
}
