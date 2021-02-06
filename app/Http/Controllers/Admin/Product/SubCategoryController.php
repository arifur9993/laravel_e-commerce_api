<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\Product\SubCategoryHandler;
use GetResponses;

class SubCategoryController extends Controller
{
    /**
     * Create Product Category
     */
    public function createSubCategory(Request $request, SubCategoryHandler $subCategoryHandler)
    {
        $validatedData = validator($request->only(
            'catId',
            'name',
            'image'

        ), [
            'catId' => 'required|exists:product_categories,id',
            'name' => 'required|unique:product_categories,name',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $subCategoryHandler->createSubCategory($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
    /**
     * Update Product Category
     */
    public function updateSubCategory(Request $request, $id, SubCategoryHandler $subCategoryHandler)
    {
        $validatedData = validator($request->only(
            'catId',
            'name',
            'image'

        ), [
            'catId' => 'exists:product_categories,id',
            'name' => 'unique:product_sub_categories,name,' . $id,
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::validationError($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $subCategoryHandler->updateSubCategory($request, $id);
        }else {
            return GetResponses::permissionError();
        } 
    }
    /**
     * List of Category
     */
    public function subCategoryList(Request $request, SubCategoryHandler $subCategoryHandler)
    {

        $user = auth('api')->user();

        if (($user->role_id == 1 ) && $user->isActive == 1) {
            return $subCategoryHandler->subCategoryList($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
}
