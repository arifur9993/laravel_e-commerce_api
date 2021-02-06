<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\Product\ProductHandler;
use GetResponses;

class ProductController extends Controller
{
     /**
     * Create Product 
     */
    public function createProduct(Request $request, ProductHandler $productHandler)
    {
        $validatedData = validator($request->only(
            'catId',
            'subCatId',
            'name',
            'description',
            'image',
            'image2',
            'image3',
            'price'

        ), [
            'catId' => 'required|exists:product_categories,id',
            'subCatId' => 'required|exists:product_sub_categories,id',
            'name' => 'required|unique:product_categories,name',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            'image2' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'image3' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'price'=> 'required|between:0,99999999.99'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $productHandler->createProduct($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
     /**
     * Create Product 
     */
    public function updateProduct(Request $request, $id, ProductHandler $productHandler)
    {
        $validatedData = validator($request->only(
            'catId',
            'subCatId',
            'name',
            'description',
            'image',
            'image2',
            'image3',
            'price'

        ), [
            'catId' => 'exists:product_categories,id',
            'subCatId' => 'exists:product_sub_categories,id',
            'name' => 'unique:product_categories,name',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'image2' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'image3' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'price'=> 'between:0,99999999.99'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $productHandler->updateProduct($request,$id);
        }else {
            return GetResponses::permissionError();
        } 
    }
     /**
     * List of Product
     */
    public function productList(Request $request, $pageNo, ProductHandler $productHandler)
    {

        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $productHandler->productList($request, $pageNo);
        }else {
            return GetResponses::permissionError();
        } 
    }
}
