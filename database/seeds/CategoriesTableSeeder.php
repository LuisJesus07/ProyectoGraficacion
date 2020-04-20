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
        $category->save();

        $category = new Category();
        $category->name = "Restaurante";
        $category->save();

        $category = new Category();
        $category->name = "Cine";
        $category->save();

        $category = new Category();
        $category->name = "Escuela";
        $category->save();

        $category = new Category();
        $category->name = "Cafetería";
        $category->save();

        $category = new Category();
        $category->name = "Bar";
        $category->save();

        $category = new Category();
        $category->name = "Tienda de ropa";
        $category->save();

        $category = new Category();
        $category->name = "Supermercado";
        $category->save();

        $category = new Category();
        $category->name = "Gimnasio";
        $category->save();

        $category = new Category();
        $category->name = "Museo";
        $category->save();

        $category = new Category();
        $category->name = "Club nocturno";
        $category->save();
    }
}
