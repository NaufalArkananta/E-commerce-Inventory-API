<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    // 6. POST /categories
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
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
