<?php

use Illuminate\Database\Seeder;
use App\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city = new City();
        $city->name = "MULEGÉ";
        $city->logo = "mulege-logo.jpg";
        $city->url_foto = "mulege.jpeg";
        $city->viewLatitud = -113.1;
        $city->viewLongitud = 27.1;
        $city->zoom = 7.5;
        $city->save();

        $city = new City();
        $city->name = "COMONDÚ";
        $city->logo = "comondu-logo.jpg";   
        $city->url_foto = "comondu.jpg";
        $city->viewLatitud = -111.7;
        $city->viewLongitud = 25.6;
        $city->zoom = 7.5;
        $city->save();

        $city = new City();
        $city->name = "LORETO";
        $city->logo = "loreto-logo.png";
        $city->url_foto = "loreto.jpg";
        $city->viewLatitud = -111.1;
        $city->viewLongitud = 25.83;
        $city->zoom = 8;
        $city->save();

        $city = new City();
        $city->name = "LA PAZ";
        $city->logo = "paz-logo.png";
        $city->url_foto = "paz.jpg";
        $city->viewLatitud = -110.7;
        $city->viewLongitud = 24.15;
        $city->zoom = 7.5;
        $city->save();

        $city = new City();
        $city->name = "LOS CABOS";
        $city->logo = "cabos-logo.png";
        $city->url_foto = "cabos.jpg";
        $city->viewLatitud = -109.7;
        $city->viewLongitud = 23.30;
        $city->zoom = 8.8;
        $city->save();
    }
}
