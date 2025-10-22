<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // List all products with pagination
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $products = Product::paginate($perPage);

        return response()->json($products);
    }

    // Show a single product by ID
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}
