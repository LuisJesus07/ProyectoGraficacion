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
        $city->save();

        $city = new City();
        $city->name = "COMONDÚ";
        $city->logo = "comondu-logo.jpg";   
        $city->url_foto = "comondu.jpg";
        $city->save();

        $city = new City();
        $city->name = "LORETO";
        $city->logo = "loreto-logo.png";
        $city->url_foto = "loreto.jpg";
        $city->save();

        $city = new City();
        $city->name = "LA PAZ";
        $city->logo = "paz-logo.png";
        $city->url_foto = "paz.jpg";
        $city->save();

        $city = new City();
        $city->name = "LOS CABOS";
        $city->logo = "cabos-logo.png";
        $city->url_foto = "cabos.jpg";
        $city->save();
    }
}
