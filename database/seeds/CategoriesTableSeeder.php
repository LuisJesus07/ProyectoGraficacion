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
        $category->name = "Hoteles";
        $category->save();

        $category = new Category();
        $category->name = "Restaurantes";
        $category->save();

        $category = new Category();
        $category->name = "Plazas";
        $category->save();

        $category = new Category();
        $category->name = "Cines";
        $category->save();
    }
}
