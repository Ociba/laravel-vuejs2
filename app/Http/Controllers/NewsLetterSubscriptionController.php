<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsSubscription;

class NewsLetterSubscriptionController extends Controller
{
   
    public function storeSubscripion(Request $request){
        $request ->validate([
            'email' =>'required',
        ]);

        $subscription =new NewsSubscription();

        $subscription ->email =$request->email;
        $subscription->save();

        return response()->json([
            'success' => true,
            'message' => 'Email created successfully',
            'subscription' => $subscription
        ], 201);
    }
}
