<?php

namespace App\Http\Controllers\Support\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\Order\OrderHandler;
use GetResponses;

class OrderController extends Controller
{
    /**
     * Get User List
     */
    public function getUserWithOrder(Request $request, OrderHandler $orderHandler)
    {
        $user = auth('api')->user();

        if (($user->role_id == 3) && $user->isActive == 1) {
            return $orderHandler->getOrderByUser();
        }else{
            return GetResponses::permissionError();

        }
    }

    /**
     * Update Order By Support
     */
    public function updateOrder(Request $request, $id, OrderHandler $orderHandler){
       
        $validatedData = validator($request->only(

            'status',
            'remarks',

        ), [
            'remarks' => 'string',
            'status' => 'integer',


        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 3) && $user->isActive == 1) {
            return $orderHandler->updateOrder($request,$id);
        }else{
            return GetResponses::permissionError();

        }
    }
}
