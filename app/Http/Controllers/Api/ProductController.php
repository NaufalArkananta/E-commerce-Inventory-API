<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;

class ProductController extends Controller
{
    // 1. POST /products
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        
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
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        
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
    public function updateStock(UpdateStockRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->stock_quantity += $request->quantity;
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
