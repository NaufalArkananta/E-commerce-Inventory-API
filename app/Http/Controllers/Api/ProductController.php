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
        $products = Product::with('category')->get();
        
        if ($products->isEmpty()) {
            return response()->json([
                'status' => " 404 Not Found",
                'message' => 'No products found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => "200 OK",
            'message' => 'Product retrieved successfully',
            'data' => $products
        ], 200);
    }

    // 3. GET /products/{id}
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        
        if (!$product) {
            return response()->json([
                'status' => " 404 Not Found",
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    // 4. PUT /products/{id}
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => " 404 Not Found",
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

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
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => " 404 Not Found",
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

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

        $products = $query->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No products found for the given filter.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => " 200 OK",
            'message' => 'Product retrieved successfully',
            'data' => $products
        ], 200);
    }

    // 9. POST /products/update-stock
    public function updateStock(UpdateStockRequest $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'status' => " 404 Not Found",
                'message' => 'Product not found',
                'data' => []
            ], 404);
        }

        $product->stock_quantity -= $request->quantity;
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
