<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adcharge;

class AdchargeController extends Controller
{
    public function getAdcharge(Request $request)
    {
        $adcharges = Adcharge::query();
    
        if ($request->filled('searchQuery')) {
            $adcharges->where('offer', 'like', '%' . $request->searchQuery . '%')
                     ->orWhere('charge', 'like', '%' . $request->searchQuery . '%')
                     ->orWhere('is_trial_eligible', 'like', '%' . $request->searchQuery . '%')
                     ->orWhere('status', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'adcharges' => $adcharges->latest()->paginate(10)
        ], 200);
    }
    

    public function store(Request $request){
        $request ->validate([
            'offer' =>'required',
            'charge' =>'required',
        ]);

        $adcharge =new Adcharge();

        $adcharge ->offer =$request->offer;
        $adcharge ->charge =$request->charge;
        $adcharge->save();

        return response()->json([
            'success' => true,
            'message' => 'Adcharge created successfully',
            'adcharge' => $adcharge
        ], 201);
    }

    public function edit($id)
    {
        $adcharge = Adcharge::findOrFail($id);

        return response()->json([
            'adcharge' => $adcharge
        ], 200);
    }


    public function update(Request $request, $id){
        $request ->validate([
            'offer' =>'required',
            'charge' =>'required',
        ]);
        $adcharge =Adcharge::find($id);

        $adcharge ->offer =$request->offer;
        $adcharge ->charge =$request->charge;
        $adcharge->save();

        return response()->json([
            'success' => true,
            'message' => 'Adcharge Saved successfully',
            'adcharge' => $adcharge
        ], 201);
    }

    public function destroy($id){
        $adcharge = Adcharge::findOrFail($id);
        $adcharge->delete();
    }
}
