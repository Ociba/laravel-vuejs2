<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();
    
        if ($request->filled('searchQuery')) {
            $categories->where('category', 'like', '%' . $request->searchQuery . '%');
        }
    
        return response()->json([
            'categories' => $categories->latest()->paginate(10)
        ], 200);
    }
    

    public function create(Request $request){
        $request ->validate([
            'category' =>'required',
            'code' => 'required',
        ]);

        $category =new Category();

        $category ->category =$request->category;
        $category ->code = $request->code;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'category' => $category
        ], 200);
    }


    public function update(Request $request, $id){
        $request ->validate([
            'category' =>'required',
            'code' => 'required',
        ]);
        $category =Category::find($id);

        $category ->category =$request->category;
       
        $category ->code = $request->code;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category Saved successfully',
            'category' => $category
        ], 201);
    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        // $category = Category::whereId($id)->delete();
        $category->delete();
    }
}
