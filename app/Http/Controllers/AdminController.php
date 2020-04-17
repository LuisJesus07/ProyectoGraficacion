<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;

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
    			->with('places.property')
    			->first();

    	return view('admin.cities.detail', compact('city'));
    }
}
