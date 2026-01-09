<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function index(){
       $products = Product::query();
       $products = $products->latest()->paginate(4);

       return response() ->json([
          'products' =>$products
       ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name'   => 'required|string|max:255',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'condition'   => 'required|string',
            'image'       => 'nullable|string', // base64
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
        $product->price      = $request->price;
        $product->condition  = $request->condition;

        if (!empty($request->image)) {
            try {
                $strpos = strpos($request->image, ';');
                $sub = substr($request->image, 0, $strpos);
                $ex = explode('/', $sub)[1];
                $name = time() . '.' . $ex;

                $upload_path = public_path('upload');

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                Image::read($request->image)
                    ->resize(200, 200)
                    ->save($upload_path . '/' . $name);

                $product->image = $name;
            } catch (\Throwable $e) {
                $product->image = 'no-image.png';
            }
        } else {
            $product->image = 'no-image.png';
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }
}
