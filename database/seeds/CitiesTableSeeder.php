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
        $city->description = "Se localiza en el extremo norte del estado. La cabecera municipal es Santa Rosalía y las ciudades más importantes son Santa Rosalía, Guerrero Negro y Mulegé.";
        $city->save();

        $city = new City();
        $city->name = "COMONDÚ";
        $city->description = "Es un municipio cuya cabecera municipal es Ciudad Constitución; se encuentra en el centro del estado de Baja California Sur.";
        $city->save();

        $city = new City();
        $city->name = "LORETO";
        $city->description = "Se ubica en la parte central del estado mexicano de Baja California Sur. Su cabecera municipal es la ciudad de Loreto.";
        $city->save();

        $city = new City();
        $city->name = "LA PAZ";
        $city->description = "Se encuentra situado en la zona sur del estado y por consiguiente la Península de Baja California, tiene una extensión territorial total de 20 274.98 kilómetros";
        $city->save();

        $city = new City();
        $city->name = "LOS CABOS";
        $city->description = "Los Cabos es uno de los municipios del estado de Baja California Sur, y se localiza en el extremo sur del estado.";
        $city->save();
    }
}
