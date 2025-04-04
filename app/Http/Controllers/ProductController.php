<?php

namespace App\Http\Controllers;

use App\Enums\CategoryNames;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ProductController extends Controller {
    /**
     * @param Request $request
     * @return JsonResponse
     * -201 Success
     * -422 Validation failure
     */
    public function createProduct(Request $request): JsonResponse {
        $request->validate([
            'name' => 'string|required',
            'category' => 'required', [new Enum(CategoryNames::class)],
            'stockQuantity' => 'integer|required|min:0',
            'price' => 'string|required|min:0',
            'active' => 'boolean|required'
        ]);
        Product::create([
            Product::COL_NAME => $request->input('name'),
            Product::COL_CATEGORY => $request->input('category'),
            Product::COL_STOCK_QUANTITY => $request->input('stockQuantity'),
            Product::COL_PRICE => $request->input('price'),
            Product::COL_ACTIVE => $request->input('active')
        ]);
        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function updateProduct(Request $request) {}

    public function deleteProduct(Request $request) {}
    public function getProduct(Request $request) {}
    public function getProductList(Request $request) {}


}
