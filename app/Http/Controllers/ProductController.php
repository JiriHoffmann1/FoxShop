<?php

namespace App\Http\Controllers;

use App\Enums\CategoryNames;
use App\Models\PriceChange;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;

class ProductController extends Controller {


    /**
     * Creates a new product
     * @param Request $request
     * @return JsonResponse
     * @response 200 - Success
     * @response 422 - Validation failure
     */
    public function createProduct(Request $request): JsonResponse {
        $request->validate([
            'name' => 'string|required',
            'category' => ['required', new Enum(CategoryNames::class)],
            'stockQuantity' => 'integer|required|min:0',
            'price' => 'numeric|required|min:0',
        ]);

        $newProduct = Product::create([
            Product::COL_NAME => $request->input('name'),
            Product::COL_CATEGORY => $request->input('category'),
            Product::COL_STOCK_QUANTITY => $request->input('stockQuantity'),
            Product::COL_PRICE => $request->input('price'),
        ]);
        return response()->json($newProduct);
    }

    /**
     * Updates existing product
     * @param Request $request
     * @urlParam id int required - Product id
     * @return JsonResponse
     * @response 200 - Success
     * @response 404 - Not found
     * @response 422 - Validation failure
     */
    public function updateProduct(Request $request): JsonResponse {
        $request->validate([
            'name' => 'string|required',
            'category' => ['required', new Enum(CategoryNames::class)],
            'stockQuantity' => 'integer|required|min:0',
            'price' => 'numeric|required|min:0',
        ]);
        $product = Product::findOrFail(Route::current()->parameter('id')); //throws 404 if product is not found
        $oldPrice = $product->getAttribute(Product::COL_PRICE);
        $newPrice = $request->input('price');

        // If price was updated, create a record of the change
        if ($oldPrice != $newPrice) {
            $product->priceChanges()->create([
                PriceChange::COL_NEW_PRICE => $newPrice,
                PriceChange::COL_OLD_PRICE => $oldPrice
            ]);
        }
        //at last, update the product
        $product->update([
            Product::COL_NAME => $request->input('name'),
            Product::COL_CATEGORY => $request->input('category'),
            Product::COL_STOCK_QUANTITY => $request->input('stockQuantity'),
            Product::COL_PRICE => $request->input('price'),
        ]);
        return response()->json($product);
    }

    /**
     * Deletes existing product
     * @urlParam id int required - Product id
     * @return JsonResponse
     * @response 200 - Success
     * @response 404 - Not found
     */
    public function deleteProduct(): JsonResponse {
        Product::findOrFail(Route::current()->parameter('id'))->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * Gets existing product
     * @urlParam id int required - Product id
     * @return JsonResponse
     * @response 200 - Success
     * @response 404 - Not found
     */
    public function getProduct(): JsonResponse {
        return response()->json(Product::findOrFail(Route::current()->parameter('id')));
    }

    /**
     * Gets list of products
     * Results can be filtered by name, category or in-stock status
     * @param Request $request
     * @return JsonResponse
     * @response 200 - Success
     * @response 422 - Validation failure
     */
    public function getProductList(Request $request): JsonResponse {
        $request->validate([
            'name' => 'string|nullable',
            'category' => ['nullable', new Enum(CategoryNames::class)],
            'inStock' => 'boolean|nullable', //NULL - gets all, TRUE - gets only in stock, FALSE - gets only out of stock
        ]);
        $query = Product::query();

        //Resolve all optional filters
        if ($name = $request->input('name')) {
            $query->where(Product::COL_NAME, 'like', '%' . $name . '%');
        }
        if ($category = $request->input('category')) {
            $query->where(Product::COL_CATEGORY, $category);
        }
        $inStock = $request->input('inStock');
        if ($inStock !== null) { //This condition allows us to filter both OUT and IN stock products
            $query->where(Product::COL_STOCK_QUANTITY, $inStock ? '>' : '=', 0);
        }

        return response()->json($query->get());
    }

    /**
     * Gets all price change records for a given product
     * @urlParam id int required - Product id
     * @return JsonResponse
     * @response 200 - Success
     * @response 404 - Not found
     */
    public function getProductPriceChanges(): JsonResponse {
        $product = Product::findOrFail(Route::current()->parameter('id'));
        $changes = $product->priceChanges()
            ->select([ //for this query, we don't need to display "updated_at" to the user. "created_at" tells us when the price changed
                PriceChange::COL_PRODUCT_ID,
                PriceChange::COL_NEW_PRICE,
                PriceChange::COL_OLD_PRICE,
                PriceChange::COL_CREATED_AT
            ])
            ->get();

        //if there are no changes for this product, return a message rather than just an empty array
        if($changes->isEmpty()) {
            return response()->json(['message' => 'The price of this product hasn\'t been changed yet']);
        } else {
            return response()->json($changes);
        }
    }

}
