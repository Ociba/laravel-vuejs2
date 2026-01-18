<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

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
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
            'location_id' => 'required|exists:locations,id',
            'sales_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'condition' => 'required|string',
            'gender' => 'required|in:unisex,women,men,children,babies',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'offer' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'color' => 'nullable|string|max:255',
            'measure' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'quantity' => 'nullable|string|max:255',
            'manufacturing_date' => 'nullable|date',
            'model' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'number_of_rooms' => 'nullable|string|max:255',
            'security' => 'nullable|string|max:255',
            'power' => 'nullable|string|max:255',
            'water' => 'nullable|string|max:255',
            'features' => 'nullable|string',
            'parking' => 'nullable|string|max:255',
            'agent_fee' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'conscent' => 'nullable|string|max:255',
            'location_status' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'fuel' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
            'steering' => 'nullable|string|max:255',
            'number_plate' => 'nullable|string|max:255',
            'engine_capacity' => 'nullable|string|max:255',
            'top_speed' => 'nullable|string|max:255',
            'number_of_cylinders' => 'nullable|string|max:255',
            'fuel_capacity' => 'nullable|string|max:255',
            'number_of_gears' => 'nullable|string|max:255',
            'age' => 'nullable|string|max:255',
            'wheel_size' => 'nullable|string|max:255',
            'body_type' => 'nullable|string|max:255',
            'watts' => 'nullable|string|max:255',
            'operating_system' => 'nullable|string|max:255',
            'graphic_card' => 'nullable|string|max:255',
            'storage_type' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'sim' => 'nullable|string|max:255',
            'display_type' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'care_information' => 'nullable|string',
            'store_information' => 'nullable|string',
            'working_hours' => 'nullable|string|max:255',
            'additional_photos' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $product = new Product();
        
        // Common fields for all categories
        $product->item_name = $request->item_name;
        $product->category_id = $request->category_id;
        $product->type_id = $request->type_id;
        $product->location_id = $request->location_id;
        $product->sales_price = $request->sales_price;
        $product->description = $request->description;
        $product->condition = $request->condition;
        $product->gender = $request->gender;
        $product->brand = $request->brand;
        $product->size = $request->size;
        $product->offer = $request->offer;
        $product->slug = Str::slug($request->item_name . '-' . Str::random(5));
        $product->discount = $request->discount ?? 0;
        $product->color = $request->color;
        $product->measure = $request->measure;
        $product->brand_name = $request->brand_name;
        $product->quantity = $request->quantity ?? '1';
        $product->manufacturing_date = $request->manufacturing_date;
        
        // Seller info
        $product->seller_id = Auth::id();
        $product->created_by = Auth::id();
        
        // Category-specific fields
        $product->breed = $request->breed;
        $product->weight = $request->weight;
        $product->model = $request->model;
        $product->material = $request->material;
        $product->number_of_rooms = $request->number_of_rooms;
        $product->security = $request->security;
        $product->power = $request->power;
        $product->water = $request->water;
        $product->features = $request->features;
        $product->parking = $request->parking;
        $product->agent_fee = $request->agent_fee;
        $product->state = $request->state;
        $product->conscent = $request->conscent;
        $product->location_status = $request->location_status;
        $product->transmission = $request->transmission;
        $product->fuel = $request->fuel;
        $product->make = $request->make;
        $product->steering = $request->steering;
        $product->number_plate = $request->number_plate;
        $product->engine_capacity = $request->engine_capacity;
        $product->top_speed = $request->top_speed;
        $product->number_of_cylinders = $request->number_of_cylinders;
        $product->fuel_capacity = $request->fuel_capacity;
        $product->number_of_gears = $request->number_of_gears;
        $product->age = $request->age;
        $product->wheel_size = $request->wheel_size;
        $product->body_type = $request->body_type;
        $product->watts = $request->watts;
        $product->operating_system = $request->operating_system;
        $product->graphic_card = $request->graphic_card;
        $product->storage_type = $request->storage_type;
        $product->processor = $request->processor;
        $product->storage = $request->storage;
        $product->ram = $request->ram;
        $product->sim = $request->sim;
        $product->display_type = $request->display_type;
        $product->expiry_date = $request->expiry_date;
        $product->care_information = $request->care_information;
        $product->store_information = $request->store_information;
        $product->working_hours = $request->working_hours;
        
        // Handle photo upload
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
                    ->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($upload_path . '/' . $name);

                $product->photo = $name;
            } catch (\Throwable $e) {
                $product->photo = 'no-image.png';
            }
        } else {
            $product->photo = 'no-image.png';
        }
        
        // Handle additional photos
        if ($request->has('additional_photos') && is_array($request->additional_photos)) {
            $additional_photos = [];
            foreach ($request->additional_photos as $index => $photoData) {
                if (!empty($photoData)) {
                    try {
                        $strpos = strpos($photoData, ';');
                        $sub = substr($photoData, 0, $strpos);
                        $ex = explode('/', $sub)[1];
                        $name = time() . '_' . $index . '.' . $ex;
                        
                        $upload_path = public_path('upload');
                        
                        Image::read($photoData)
                            ->resize(800, 800, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->save($upload_path . '/' . $name);
                        
                        $additional_photos[] = $name;
                    } catch (\Throwable $e) {
                        // Skip invalid photos
                    }
                }
            }
            $product->additional_photos = !empty($additional_photos) ? json_encode($additional_photos) : null;
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
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
            'location_id' => 'required|exists:locations,id',
            'sales_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'condition' => 'required|string',
            'gender' => 'required|in:unisex,women,men,children,babies',
            'brand' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'offer' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'status' => 'required|in:available,sold,stopped',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Update common fields
        $product->item_name = $request->item_name;
        $product->category_id = $request->category_id;
        $product->type_id = $request->type_id;
        $product->location_id = $request->location_id;
        $product->sales_price = $request->sales_price;
        $product->description = $request->description;
        $product->condition = $request->condition;
        $product->gender = $request->gender;
        $product->brand = $request->brand;
        $product->size = $request->size;
        $product->offer = $request->offer;
        $product->discount = $request->discount ?? $product->discount;
        $product->color = $request->color ?? $product->color;
        $product->measure = $request->measure ?? $product->measure;
        $product->brand_name = $request->brand_name ?? $product->brand_name;
        $product->quantity = $request->quantity ?? $product->quantity;
        $product->manufacturing_date = $request->manufacturing_date ?? $product->manufacturing_date;
        $product->status = $request->status;
        $product->updated_by = Auth::id();
        
        // Update category-specific fields if provided
        if ($request->has('breed')) $product->breed = $request->breed;
        if ($request->has('weight')) $product->weight = $request->weight;
        if ($request->has('model')) $product->model = $request->model;
        
        // Update photo if provided
        if (!empty($request->photo) && $request->photo !== $product->photo) {
            try {
                $strpos = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $strpos);
                $ex = explode('/', $sub)[1];
                $name = time() . '.' . $ex;

                $upload_path = public_path('upload');

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                // Delete old photo if it exists and not default
                if ($product->photo && $product->photo !== 'no-image.png') {
                    $old_photo = $upload_path . '/' . $product->photo;
                    if (file_exists($old_photo)) {
                        @unlink($old_photo);
                    }
                }

                Image::read($request->photo)
                    ->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($upload_path . '/' . $name);

                $product->photo = $name;
            } catch (\Throwable $e) {
                // Keep existing photo if error
            }
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $image_path = public_path(). "/upload/";
        $photo =$image_path .$product->photo;
        if(file_exists($photo)){
            @unlink($photo);
        }
        $product->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}