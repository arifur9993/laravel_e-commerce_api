<?php

namespace App\Modules\Support\Order;

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
     * User List for Support
     */
    public function userList()
    {
        $getUser = User::with('hasDetails', 'hasOrder')->where('role_id',2)->orderBy('id', 'desc')->get();
        if(count($getUser)!=0){
         $returnData=[];
         foreach($getUser as $user){
             $details = [
                 'userInfo'=>$user->hasDetails,
                 'orderInfo'=>$user->hasOrder
             ];
             array_push($returnData,$details);
         }
         return GetResponses::returnData($returnData);
        }
        return GetResponses::noRecords();
    }

    /**
     * Update Order By Support
     * Only Can Change Remark and Status
     */
    public function updateOrder($request,$id)
    {
        $findOrder = Order::where('id', $id)->first();
        // dd($findOrder);
        if ($findOrder != null) {
            //Change Status
            if(isset($request->status)){
                $findOrder->status =$request->status;
            }
            //Add Remark
            if(isset($request->remarks)){
                $findOrder->remarks =$request->remarks;
            }
            $findOrder->update();
            return GetResponses::updateSuccess();
        }
        return GetResponses::inputValidationError();
    }
  

}
