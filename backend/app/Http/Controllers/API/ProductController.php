<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Add this line

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    // POST /api/products
    public function store(Request $request)
    {
        $product = Product::create($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'nullable|string',
        ]));

        return new ProductResource($product);
    }

    // GET /api/products/{id}
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    // PUT /api/products/{id}
    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'sometimes|required|numeric',
            'mrp_price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|integer',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $product->id, 
        ]));

        return new ProductResource($product);
    }

    // DELETE /api/products/{id}
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
