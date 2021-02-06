<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\Product\CategoryHandler;
use GetResponses;

class CategoryController extends Controller
{
    /**
     * Create Product Category
     */
    public function createCategory(Request $request, CategoryHandler $categoryHandler){
        $validatedData = validator($request->only(
            'name',
            'image'

        ), [
            'name' => 'required|unique:product_categories,name',
            'image'=>'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $categoryHandler->createCategory($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
    /**
     * Update Product Category
     */
    public function updateCategory(Request $request, $id, CategoryHandler $categoryHandler){
        $validatedData = validator($request->only(
            'name',
            'image'

        ), [
            'name' => 'unique:product_categories,name,'.$id,
            'image'=>'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $categoryHandler->updateCategory($request,$id);
        }else {
            return GetResponses::permissionError();
        } 
    }
    /**
     * List of Category
     */
    public function categoryList(Request $request, CategoryHandler $categoryHandler){
      
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $categoryHandler->categoryList($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
}
