<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        try {
            $products = Product::all();
            return ResponseFormatter::success(
                $products,
                'Product List'
            );
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createProduct(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:1',
                'stock' => 'required|integer|min:0',
            ]);

            $product = Product::create($validatedData);

            return ResponseFormatter::success(
                $product,
                'Product created successfully'
            );
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductsByID($id)
    {

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return ResponseFormatter::success(
            $product,
            'Product Detail'
        );
    }

    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'price' => 'nullable|integer',
            'stock' => 'nullable|integer',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update(array_filter($validatedData));
        return ResponseFormatter::success(
            $product,
            'Product updated successfully'
        );
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            $product->delete();
            return ResponseFormatter::success(
                $product,
                'Product deleted successfully'
            );
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to delete product',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
