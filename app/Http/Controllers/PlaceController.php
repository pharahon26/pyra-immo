<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    

    public function index(){
        return view('catalogue.places.index');
    }
    
    public function create(){
        return view('catalogue.places.create');
    }
    
    public function edit($house_id){
        $place = Place::findOrFail($house_id);
        return view('catalogue.places.edit', ['place' => $place]);
    }
    
    public function show($house_id){
        $place = Place::findOrFail($house_id);
        return view('catalogue.places.show', ['place' => $place]);
    }
    public function delete($house_id){
        $place = Place::firstOrFail($house_id);
        /// check if the user is the authorized to delete
        $place->deleteOrFail();
        return redirect('catalogue.places.index');
    }

}
