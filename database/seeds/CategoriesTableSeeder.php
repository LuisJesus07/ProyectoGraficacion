<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = "Hotel";
        $category->url_icon = "hotel.png";
        $category->save();

        $category = new Category();
        $category->name = "Restaurante";
        $category->url_icon = "restaurante.png";
        $category->save();

        $category = new Category();
        $category->name = "Cine";
        $category->url_icon = "cine.png";
        $category->save();

        $category = new Category();
        $category->name = "Escuela";
        $category->url_icon = "escuela.png";
        $category->save();

        $category = new Category();
        $category->name = "Cafetería";
        $category->url_icon = "cafeteria.png";
        $category->save();

        $category = new Category();
        $category->name = "Bar";
        $category->url_icon = "bar.png";
        $category->save();

        $category = new Category();
        $category->name = "Tienda de ropa";
        $category->url_icon = "tienda_de_ropa.png";
        $category->save();

        $category = new Category();
        $category->name = "Supermercado";
        $category->url_icon = "supermercado.png";
        $category->save();

        $category = new Category();
        $category->name = "Gimnasio";
        $category->url_icon = "gimnasio.png";
        $category->save();

        $category = new Category();
        $category->name = "Museo";
        $category->url_icon = "museo.png";
        $category->save();

        $category = new Category();
        $category->name = "Club nocturno";
        $category->url_icon = "club_nocturno.png";
        $category->save();

        $category = new Category();
        $category->name = "Playa";
        $category->url_icon = "playa.png";
        $category->save();
    }
}
