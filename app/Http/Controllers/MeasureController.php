<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measure;

class MeasureController extends Controller
{
    public function getMeasure(Request $request)
    {
        $measures = Measure::query();
    
        if ($request->filled('searchQuery')) {
            $measures->where('measure', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'measures' => $measures->latest()->paginate(10)
        ], 200);
    }
    

    public function store(Request $request){
        $request ->validate([
            'measure' =>'required',
        ]);

        $measure =new Measure();

        $measure ->measure =$request->measure;
        $measure->save();

        return response()->json([
            'success' => true,
            'message' => 'Measure created successfully',
            'measure' => $measure
        ], 201);
    }

    public function edit($id)
    {
        $measure = Measure::findOrFail($id);

        return response()->json([
            'measure' => $measure
        ], 200);
    }


    public function update(Request $request, $id){
        $request ->validate([
            'measure' =>'required',
        ]);
        $measure =Measure::find($id);

        $measure ->measure =$request->measure;

        $measure->save();

        return response()->json([
            'success' => true,
            'message' => 'Measure Saved successfully',
            'measure' => $measure
        ], 201);
    }

    public function destroy($id){
        $measure = Measure::findOrFail($id);
        $measure->delete();
    }
}
