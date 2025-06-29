<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    // 1. POST /products
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);
        
        return response()->json([
            'status' => " 201 OK",
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    // 2. GET /products
    public function index()
    {
        return response()->json([
            'status' => "200 OK",
            'message' => 'Product retrieved successfully',
            'data' => Product::with('category')->get()
        ], 200);
    }

    // 3. GET /products/{id}
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    // 4. PUT /products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock_quantity' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    // 5. DELETE /products/{id}
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product deleted successfully',
            'data' => $product
        ], 200);
    }

    // 8. GET /products/search
    public function search(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product retrieved successfully',
            'data' => $query->get()
        ], 200);
    }

    // 9. POST /products/update-stock
    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $product->stock_quantity += $validated['quantity']; // bisa positif/negatif
        $product->save();

        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    // 10. GET /inventory/value
    public function inventoryValue()
    {
        $total = Product::sum(DB::raw('price * stock_quantity'));

        return response()->json([
            'status' => 200,
            'message' => 'Total inventory value retrieved successfully',
            'data' => [
                'total_value' => $total
            ]
        ]);
    }
}
