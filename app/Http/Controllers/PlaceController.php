<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

class PlaceController extends Controller
{
    
    public function index()
    {
    	$places = Place::with('property','geometry')->get();

    	return view('mapa.index');
    }


    public function getPlacesByCity($city_id)
    {
    	
    	$places = Place::with('property','geometry','category')
    				->where('city_id',$city_id)
                    ->where('status','active')
    				->get();

    	
    	$feautues = array();
    	$feautues['feautues'] = array();

    	foreach ($places as $place) {

    		$lugar = array(

    			'geometry' => array(
    							'coordinates' => [$place->geometry->longitud, $place->geometry->latitud]
    						),
    			'properties' => array(
                                'id' => $place->property->id,
    							'name' => $place->property->name,
    							'description' => $place->property->description,
                                'category' => $place->category->name,
                                'marker-symbol' => 'cafe'
    						)
    		);
    		
    		array_push($feautues["feautues"], $lugar);
    	}

    	return $feautues;
    }

    public function getPlaceById($id)
    {
        $place = Place::where('id',$id)
                 ->with('property','category')
                 ->first();

        return $place;
    }


}
