<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * GET all types with category
     */
    public function index()
    {
        $types = Type::with('category')->get();

        return response()->json([
            'types' => $types
        ]);
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
