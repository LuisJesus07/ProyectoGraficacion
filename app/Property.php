<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_foto', 'name', 'description', 'address', 'horario', 'web'
    ];


    public function place()
    {
    	return $this->belongsTo(Place::class);
    }
}
