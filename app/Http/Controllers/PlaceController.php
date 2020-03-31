<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

class PlaceController extends Controller
{
    
    public function index()
    {
    	$places = Place::with('property','geometry')->get();

    	
    	$feautues = array();
    	$feautues['feautues'] = array();

    	foreach ($places as $place) {

    		$lugar = array(

    			'geometry' => array(
    							'coordinates' => [$place->geometry->latitud, $place->geometry->longitud]
    						),
    			'properties' => array(
    							'name' => $place->property->name,
    							'description' => $place->property->description
    						)
    		);
    		
    		array_push($feautues["feautues"], $lugar);
    	}

    	//return $feautues;

    	return view('mapa.index', compact('feautues'));
    }
}
