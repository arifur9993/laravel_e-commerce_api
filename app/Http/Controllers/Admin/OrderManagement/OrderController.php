<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GetResponses;
use App\Modules\Admin\Order\OrderHandler;

class OrderController extends Controller
{
    /**
     * Get Order for all user 
     */
    public function getOrderByUser(Request $request, OrderHandler $orderHandler)
    {
        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $orderHandler->getOrderByUser();
        } else {
            return GetResponses::permissionError();
        }
    }

    /**
     * Update Order everything
     */
    public function updateOrder(Request $request, $id, OrderHandler $orderHandler)
    {
        $validatedData = validator($request->only(

            'paymentStatus',
            'billingAddress',
            'trackingNo',
            'status',
            'remarks',

        ), [
            'paymentStatus'=>'integer',
            'billingAddress'=>'string',
            'trackingNo'=>'string',
            'remarks' => 'string',
            'status' => 'integer',


        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $orderHandler->getOrderByUser();
        } else {
            return GetResponses::permissionError();
        }
    }

    /**
     * Delete Order
     */
    public function deleteOrder(Request $request, $id, OrderHandler $orderHandler){
        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $orderHandler->orderDelete($id);
        } else {
            return GetResponses::permissionError();
        } 
    }
}
