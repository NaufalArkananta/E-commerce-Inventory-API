<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 6. POST /categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $category = Category::create($validated);
        return response()->json([
            'status' => " 201 OK",
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    // 7. GET /categories
    public function index()
    {
        return response()->json([
            'status' => " 200 OK",
            'message' => 'Category retrieved successfully',
            'data' => Category::all()
        ], 200);
    }
}
