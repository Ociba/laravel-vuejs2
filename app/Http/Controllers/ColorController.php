<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function getColor(Request $request)
    {
        $colors = Color::query();
    
        if ($request->filled('searchQuery')) {
            $colors->where('color', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'colors' => $colors->latest()->paginate(10)
        ], 200);
    }
    

    public function store(Request $request){
        $request ->validate([
            'color' =>'required',
        ]);

        $color =new Color();

        $color ->color =$request->color;
        $color->save();

        return response()->json([
            'success' => true,
            'message' => 'Color created successfully',
            'color' => $color
        ], 201);
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return response()->json([
            'color' => $color
        ], 200);
    }


    public function update(Request $request, $id){
        $request ->validate([
            'color' =>'required',
        ]);
        $color =Color::find($id);

        $color ->color =$request->color;

        $color->save();

        return response()->json([
            'success' => true,
            'message' => 'Color Saved successfully',
            'color' => $color
        ], 201);
    }

    public function destroy($id){
        $color = Color::findOrFail($id);
        $color->delete();
    }
}
