<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * GET all types with category (filter by category if provided)
     */
    public function index(Request $request)
    {
        $query = Type::with('category');
        
        // Filter by category_id if provided
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        
        $types = $query->paginate(10);

        return response()->json([
            'types' => $types
        ],200);
    }

    /**
     * GET type for edit
     */
    public function edit($id)
    {
        $type = Type::findOrFail($id);

        return response()->json([
            'type' => $type
        ]);
    }

    /**
     * CREATE a new type
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'type' => ['required', 'string', 'max:255'],
            'group' => ['nullable', 'string', 'max:255'],
        ]);

        $type = Type::create($validated);

        return response()->json([
            'message' => 'Type created successfully',
            'type' => $type
        ], 201);
    }

    /**
     * UPDATE type
     */
    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);

        $validated = $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'type' => ['required', 'string', 'max:255'],
            'group' => ['nullable', 'string', 'max:255'],
        ]);

        $type->update($validated);

        return response()->json([
            'message' => 'Type updated successfully',
            'type' => $type
        ]);
    }

    /**
     * DELETE type
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return response()->json([
            'message' => 'Type deleted successfully'
        ]);
    }
}