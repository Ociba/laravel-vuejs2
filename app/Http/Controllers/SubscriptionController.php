<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsSubscription;

class SubscriptionController extends Controller
{
    public function getNewsSubscription(Request $request)
    {
        $news = NewsSubscription::query();
    
        if ($request->filled('searchQuery')) {
            $news->where('email', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'news' => $news->latest()->paginate(10)
        ], 200);
    }

    public function destroy($id){
        $news = NewsSubscription::findOrFail($id);
        $news->delete();
    }
}
