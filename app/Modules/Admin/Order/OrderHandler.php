<?php

namespace App\Modules\Admin\Order;

use App\Models\Auth\User;
use App\Models\Auth\UserDetail;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use Carbon\Carbon;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class OrderHandler
{

    /**
     * User List for Admin
     */
    public function getOrderByUser()
    {
        $getUser = User::with('hasDetails', 'hasOrder')->where('role_id', 2)->orderBy('id', 'desc')->get();
        if (count($getUser) != 0) {
            $returnData = [];
            foreach ($getUser as $user) {
                $details = [
                    'userInfo' => $user->hasDetails,
                    'orderInfo' => $user->hasOrder
                ];
                array_push($returnData, $details);
            }
            return GetResponses::returnData($returnData);
        }
        return GetResponses::noRecords();
    }

    /**
     * Update Order By Admin
     */
    public function updateOrder($request, $id)
    {
        $findOrder = Order::where('id', $id)->first();
        // dd($findOrder);
        if ($findOrder != null) {
            //Change Billing address
            if (isset($request->billingAddress)) {
                $findOrder->billing_address = $request->billingAddress;
            }
            //Change Tracking No
            if (isset($request->trackingNo)) {
                $findOrder->tracking_number = $request->trackingNo;
            }
            //Change Payment Status
            if (isset($request->paymentStatus)) {
                $findOrder->payment_status = $request->paymentStatus;
            }
            //Change Status
            if (isset($request->status)) {
                $findOrder->status = $request->status;
            }
            //Add Remark
            if (isset($request->remarks)) {
                $findOrder->remarks = $request->remarks;
            }
            $findOrder->update();
            return GetResponses::updateSuccess();
        }
        return GetResponses::inputValidationError();
    }

    /**
     * Delete Order 
     * 
     */
    public function orderDelete($id)
    {
        $findOrder = Order::find($id);
        if ($findOrder != null) {
            $findOrder->delete();
            return GetResponses::deleteSuccess();
        } else {
            return GetResponses::inputValidationError();
        }
    }
}
