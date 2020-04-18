<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Category;
use App\Geometry;
use App\Property;
use App\Place;

class AdminController extends Controller
{
    
    public function index()
    {
        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }


    public function city_detail($id)
    {
    	$city = City::where('id',$id)
    			->with(['places' => function($q){
                    $q->orderBy('created_at','DESC');
                    $q->with('property');
                    $q->with('category');
                }])
    			->first();

    	$categories = Category::all();

    	return view('admin.cities.detail', compact('city','categories'));
    }

    public function store_place(Request $request)
    {
    	//guardar lat y lng
    	$geometry = Geometry::create($request->all());

    	//guardar propiedades(del lugar)
    	$property = Property::create($request->all());

    	if($property->save()){

    		//guardar la foto
    		if($request->hasFile('url_foto')){

    			$name_file = $property->id."_".str_replace(' ','_',strtolower($property->name)).".".$request->url_foto->getClientOriginalExtension();

                $path = $request->file('url_foto')->storeAs(
                    '/fotos_places/', $name_file
                ); 

                $property->url_foto = $name_file;
                $property->save();
    		}

    		//guardar el lugar
    		$place = Place::create(['city_id' => $request->city_id,
    								'geometry_id' => $geometry->id,
    								'property_id' => $property->id,
    								'category_id' => $request->category_id]);

    		if($place->save()){

    			return redirect()->back()->with('success','ok');
    		}

            return redirect()->back()->with('error','ok');

    	}

    }

    public function update_place(Request $request)
    {

        $place = Place::find($request->place_id);
        $property = Property::find($request->property_id);
        $geometry = Geometry::find($request->geometry_id);

        //actualizar categoria del lugar(si es diferente)
        if($place->category_id != $request->category_id){
            $place->category_id = $request->category_id;
            $place->save();
        }

        //actualizar las propiedades del lugar
        $property->update($request->all());
        if($request->hasFile('url_foto')){

            $name_file = $property->id."_".str_replace(' ','_',strtolower($property->name)).".".$request->url_foto->getClientOriginalExtension();

            $path = $request->file('url_foto')->storeAs(
                '/fotos_places/', $name_file
            ); 

            $property->url_foto = $name_file;
            $property->save();
        }

        //actualizar las cordenadas
        $geometry->update($request->all());

        return redirect()->back()->with('success','ok');
    }

    public function place_detail($id)
    {
        $place = Place::where('id',$id)
                 ->with('property', 'category', 'geometry')
                 ->first();
                 
        $categories = Category::all();

        return view('admin.places.detail', compact('categories', 'place'));
    }
}
