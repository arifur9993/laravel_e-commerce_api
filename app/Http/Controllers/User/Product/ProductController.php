<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\Product\ProductHandler;
use GetResponses;

class ProductController extends Controller
{
    /**
     * Get Product List 
     * This api will show the product list 
     */
    public function showProduct(Request $request, ProductHandler $productHanlder)
    {
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->showProduct($request);
        }else{
            return GetResponses::permissionError();

        }
    }
    /**
     * Get Product Deatils
     * This api will show a particular Product Deatils
     */
    public function productDeatils(Request $request, $id, ProductHandler $productHanlder)
    {
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->viewDetails($id);
        }else{
            return GetResponses::permissionError();

        }
    }

    /**
     * Add To cart 
     */
    public function addToCart(Request $request, ProductHandler $productHanlder)
    {
        $validatedData = validator($request->only(

            'productId',
            'quantity',

        ), [
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer',


        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->addToCart($request, $user->id);
        }else{
            return GetResponses::permissionError();

        }
    }
    /**
     * Remove Cart
     */
    public function removeCart(Request $request, $id, ProductHandler $productHanlder)
    {
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->removeCart($id, $user->id);
        }else{
            return GetResponses::permissionError();

        }
    }
    /**
     * Checkout Cart
     */
    public function checkOut(Request $request, ProductHandler $productHanlder)
    {
        $validatedData = validator($request->only(

            'productId',
            'quantity',

        ), [
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer',


        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->checkOut($user->id);
        }else{
            return GetResponses::permissionError();

        }
    }
    /**
     * Make Order
     */
    public function makeOrder(Request $request, ProductHandler $productHanlder)
    {
        $validatedData = validator($request->only(

            'cartId',
            'billingAddress',

        ), [
            'cartId' => 'required|array',
            'cartId.*' => 'required|exists:carts,id',
            'billingAddress' => 'required|max:500',


        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->makeOrder($request);
        }else{
            return GetResponses::permissionError();

        }
    }

    /**
     * View Order for Particular User
     */
    public function myOrder(Request $request, ProductHandler $productHanlder)
    {
        $user = auth('api')->user();

        if (($user->role_id == 2) && $user->isActive == 1) {
            return $productHanlder->viewOrder($user->id);
        }else{
            return GetResponses::permissionError();

        }
    }
}
