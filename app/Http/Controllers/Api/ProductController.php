<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     * 
     * GET /api/products
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $products = Product::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => $products,
                'count' => $products->count(),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving products',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created product in storage.
     * 
     * POST /api/products
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|unique:products,slug',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0|max:9999999.99',
                'stock' => 'required|integer|min:0',
                'sku' => 'nullable|string|unique:products,sku',
                'active' => 'sometimes|boolean',
            ]);

            // Set default value for active if not provided
            $validated['active'] = $validated['active'] ?? true;

            // Create the product
            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product,
            ], Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating product',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified product.
     * 
     * GET /api/products/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        try {
            // Validate that ID is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product ID',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Find product by ID
            $product = Product::find($id);

            // Check if product exists
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product retrieved successfully',
                'data' => $product,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving product',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified product in storage.
     * 
     * PUT/PATCH /api/products/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate that ID is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product ID',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Find product by ID
            $product = Product::find($id);

            // Check if product exists
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Validate incoming request data
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'slug' => 'sometimes|string|unique:products,slug,' . $id,
                'description' => 'nullable|string',
                'price' => 'sometimes|numeric|min:0|max:9999999.99',
                'stock' => 'sometimes|integer|min:0',
                'sku' => 'nullable|string|unique:products,sku,' . $id,
                'active' => 'sometimes|boolean',
            ]);

            // Update the product
            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product,
            ], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified product from storage.
     * 
     * DELETE /api/products/{id}
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Validate that ID is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid product ID',
                ], Response::HTTP_BAD_REQUEST);
            }

            // Find product by ID
            $product = Product::find($id);

            // Check if product exists
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], Response::HTTP_NOT_FOUND);
            }

            // Store product data before deletion for response
            $deletedProduct = $product->toArray();

            // Delete the product
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
                'data' => $deletedProduct,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Bulk delete products.
     * 
     * DELETE /api/products/bulk-delete
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer',
            ]);

            $deletedCount = Product::whereIn('id', $validated['ids'])->delete();

            return response()->json([
                'success' => true,
                'message' => 'Products deleted successfully',
                'deleted_count' => $deletedCount,
            ], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting products',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Search products by name or SKU.
     * 
     * GET /api/products/search?q=keyword
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q');

            if (!$query) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query is required',
                ], Response::HTTP_BAD_REQUEST);
            }

            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Search completed',
                'query' => $query,
                'data' => $products,
                'count' => $products->count(),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching products',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
