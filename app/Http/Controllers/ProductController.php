<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
   public function index(Request $request)
    {
        $query = Product::query();
        
        // Search across multiple columns
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('item_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('condition', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('status', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Filter by condition
        if ($request->has('condition')) {
            $conditions = explode(',', $request->condition);
            $query->whereIn('condition', $conditions);
        }
        
        // Filter by status (default to available)
        if ($request->has('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        } else {
            // Default: only show available products
            $query->where('status', 'available');
        }
        
        // Sales Price range filter (optional)
        if ($request->has('min_price')) {
            $query->where('sales_price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price')) {
            $query->where('sales_price', '<=', $request->max_price);
        }
        
        // Paginate results
        $products = $query->orderBy('created_at', 'desc')
                         ->paginate(12);
        
        return response()->json([
            'products' => $products,
            'filters' => $request->all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name'   => 'required|string|max:255',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'description' => 'required|string',
            'sales_price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'photo'       => 'nullable|string', // base64
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $product = new Product();
        $product->item_name  = $request->item_name;
        $product->discount   = $request->discount;
        $product->description = $request->description;
        $product->sales_price      = $request->sales_price;
        $product->condition  = $request->condition;
        
        $product->seller_id  = Auth::user()->id;

        if (!empty($request->photo)) {
            try {
                $strpos = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $strpos);
                $ex = explode('/', $sub)[1];
                $name = time() . '.' . $ex;

                $upload_path = public_path('upload');

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                Image::read($request->photo)
                    ->resize(200, 200)
                    ->save($upload_path . '/' . $name);

                $product->photo = $name;
            } catch (\Throwable $e) {
                $product->photo = 'no-image.png';
            }
        } else {
            $product->photo = 'no-image.png';
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function countSellerProducts(Request $request)
{
    $count = Product::where('seller_id', $request->user()->id)->count();
    
    return response()->json([
        'success' => true,
        'count' => $count
    ]);
}

public function getMyProducts(Request $request)
{
    $products = Product::query();

    if($request->searchQuery != ''){
        $products = Product::where('item_name','like','%'.$request->searchQuery . '%');
    }
    $products = $products->where('seller_id', auth()->user()->id)->latest()->paginate(2);
    
    return response()->json([
        'products' => $products
    ], 200);
}

public function view($id){
    $product =Product::find($id);
    return response()->json([
        'product' =>$product
    ], 200);
}

public function edit($id)
{
    $product =Product::find($id);
    return response()->json([
        'product' =>$product
    ], 200);
}

public  function update(Request $request, $id)
{
    $request->validate([
        'item_name' => 'required',
        'sales_price' => 'required',
        'condition' => 'required',
        'description' => 'required',
        'status' => 'required',
        'photo' => 'required',
    ]);

    $product= Product::find($id);

    $product->item_name  = $request->item_name;
        $product->discount   = $request->discount;
        $product->description = $request->description;
        $product->sales_price      = $request->sales_price;
        $product->condition  = $request->condition;
        
        $product->seller_id  = Auth::user()->id;

        if (!empty($request->photo)) {
            try {
                $strpos = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $strpos);
                $ex = explode('/', $sub)[1];
                $name = time() . '.' . $ex;

                $upload_path = public_path('upload');

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                Image::read($request->photo)
                    ->resize(200, 200)
                    ->save($upload_path . '/' . $name);

                $product->photo = $name;
            } catch (\Throwable $e) {
                $product->photo = $product->photo;
            }
        } else {
            $product->photo = $product->photo;
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
}

public function destroy($id){
    $product = Product::findOrFail($id);
    $image_path = public_path(). "/upload/";
    $photo =$image_path .$product->photo;
    if(file_exists($photo)){
        @unlink($photo);
    }
    $product->delete();
}
}
