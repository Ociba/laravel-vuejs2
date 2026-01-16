<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        $locations = Location::query();
    
        if ($request->filled('searchQuery')) {
            $locations->where('location', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'locations' => $locations->latest()->paginate(10)
        ], 200);
    }
    

    public function store(Request $request){
        $request ->validate([
            'location' =>'required',
        ]);

        $location =new Location();

        $location ->location =$request->location;
        $location->save();

        return response()->json([
            'success' => true,
            'message' => 'Location created successfully',
            'location' => $location
        ], 201);
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);

        return response()->json([
            'location' => $location
        ], 200);
    }


    public function update(Request $request, $id){
        $request ->validate([
            'location' =>'required',
        ]);
        $location =Location::find($id);

        $location ->location =$request->location;

        $location->save();

        return response()->json([
            'success' => true,
            'message' => 'location Saved successfully',
            'location' => $location
        ], 201);
    }

    public function destroy($id){
        $location = Location::findOrFail($id);
        $location->delete();
    }
}
