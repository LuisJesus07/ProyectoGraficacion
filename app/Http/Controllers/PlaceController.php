<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

class PlaceController extends Controller
{
    
    public function index()
    {
    	$places = Place::with('property','geometry')->get();

        $json_cities = json_decode(file_get_contents("../database/jsons/cities.json",true));

        $cities = get_object_vars($json_cities);

    	
        //////////////features
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
        ///////////////////feautures


    	return view('mapa.index', compact('feautues','cities'));
    }


    public function getPlacesByCity($city_id)
    {
    	
    	$places = Place::with('property','geometry','category')
    				->where('city_id',$city_id)
    				->get();

    	
    	$feautues = array();
    	$feautues['feautues'] = array();

    	foreach ($places as $place) {

    		$lugar = array(

    			'geometry' => array(
    							'coordinates' => [$place->geometry->latitud, $place->geometry->longitud]
    						),
    			'properties' => array(
                                'id' => $place->property->id,
    							'name' => $place->property->name,
    							'description' => $place->property->description,
                                'category' => $place->category->name
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
