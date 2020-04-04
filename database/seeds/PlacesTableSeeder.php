<?php

use Illuminate\Database\Seeder;
use App\Geometry;
use App\Property;
use App\Place;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ///////lugar
    	$geometry = new Geometry();
    	$geometry->latitud = -109.514;
    	$geometry->longitud = 23.400;
    	$geometry->save();

    	$property = new Property();
    	$property->name = "Plaza paseo la paz";
    	$property->description = "Plaza ubicada en los cabos";
    	$property->save();

    	$place = new Place();
    	$place->city_id = 5;
    	$place->geometry_id = $geometry->id;
    	$place->property_id = $property->id;
    	$place->save();
        ////////////lugar

        ///////lugar
        $geometry = new Geometry();
        $geometry->latitud = -109.614;
        $geometry->longitud = 23.300;
        $geometry->save();

        $property = new Property();
        $property->name = "Cinepolis";
        $property->description = "Plaza centro";
        $property->save();

        $place = new Place();
        $place->city_id = 5;
        $place->geometry_id = $geometry->id;
        $place->property_id = $property->id;
        $place->save();
        ////////////lugar


        ///////lugar
        $geometry = new Geometry();
        $geometry->latitud = -110.914;
        $geometry->longitud = 24.600;
        $geometry->save();

        $property = new Property();
        $property->name = "Restaurante Mariscos";
        $property->description = "Restaurante de mariscos";
        $property->save();

        $place = new Place();
        $place->city_id = 2;
        $place->geometry_id = $geometry->id;
        $place->property_id = $property->id;
        $place->save();
        ////////////lugar
    }
}
