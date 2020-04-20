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
        $geometry->longitud = -110.339948;
    	$geometry->latitud = 24.135075;
    	$geometry->save();

    	$property = new Property();
        $property->url_foto = "asadero.jpg";
    	$property->name = "Asadero del Javy";
    	$property->description = "casa del tortugón";
        $property->address = "Av, Blvd. Constituyentes de 1975 s/n, El Conchalito, 23090 La Paz, B.C.S.";
        $property->horario = "Lunes a Sabado de 9:00 a 19:00";
        $property->phone_number = "6122031714";
        $property->web = "saboreslapaz.com.mx";
    	$property->save();

    	$place = new Place();
    	$place->city_id = 4;
    	$place->geometry_id = $geometry->id;
    	$place->property_id = $property->id;
        $place->category_id = 2;
    	$place->save();
        ////////////lugar

        
    }
}
