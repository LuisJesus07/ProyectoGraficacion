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
        $geometry->longitud = -109.514;
    	$geometry->latitud = 23.400;
    	$geometry->save();

    	$property = new Property();
        $property->url_foto = "plaza.jpg";
    	$property->name = "Plaza paseo la paz";
    	$property->description = "Plaza ubicada en los cabos";
        $property->address = "Calle 12 entre altamirano";
        $property->horario = "Lunes a Viernes de 7:00 a 18:00";
        $property->web = "www.paseo-la-paz.com";
    	$property->save();

    	$place = new Place();
    	$place->city_id = 5;
    	$place->geometry_id = $geometry->id;
    	$place->property_id = $property->id;
        $place->category_id = 3;
    	$place->save();
        ////////////lugar

        ///////lugar
        $geometry = new Geometry();
        $geometry->longitud = -109.6961107847261;
        $geometry->latitud = 23.05782119411029;
        $geometry->save();

        $property = new Property();
        $property->url_foto = "cinepolis.jpg";
        $property->name = "Cinepolis";
        $property->description = "Plaza centro";
        $property->address = "Calle justicia entre soberania";
        $property->horario = "Lunes a Sabado de 8:00 a 17:00";
        $property->web = "www.cinepolis.com";
        $property->save();

        $place = new Place();
        $place->city_id = 5;
        $place->geometry_id = $geometry->id;
        $place->property_id = $property->id;
        $place->category_id = 4;
        $place->save();
        ////////////lugar


        ///////lugar
        $geometry = new Geometry();
        $geometry->longitud = -110.914;
        $geometry->latitud = 24.600;
        $geometry->save();

        $property = new Property();
        $property->url_foto = "mariscos.jpg";
        $property->name = "Restaurante Mariscos";
        $property->description = "Restaurante de mariscos";
        $property->address = "Calle principal entre calle 2";
        $property->horario = "Lunes a Sabado de 9:00 a 20:00, Domingos de 10:00 a 15:00 ";
        $property->web = "www.mariscos.com";
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
