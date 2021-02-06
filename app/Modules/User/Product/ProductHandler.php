<?php

namespace App\Modules\User\Product;

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


class ProductHandler
{

    /**
     * Product for User
     */
    public function showProduct($request)
    {
        // dd($request);
        $getProduct = Product::with('hasCat', 'hasSubCat')->orderBy('name', 'asc')->get();
        return GetResponses::returnData($getProduct);
    }

    /**
     * View Details of Product
     */
    public function viewDetails($id)
    {
        $findProduct = Product::with('hasCat', 'hasSubCat')->where('id', $id)->first();
        if ($findProduct != null) {
            return GetResponses::returnData($findProduct);
        }
        return GetResponses::inputValidationError();
    }
    /**
     * Add To cart
     */
    public function addToCart($request, $userId)
    {

        $findProduct = Product::with('hasCat', 'hasSubCat')->where('id', $request->productId)->first();
        if ($findProduct != null) {
            $price = $findProduct->price;
            $quantity = $request->quantity;
            $totalPrice = $this->totalPrice($price, $quantity);
            // dd($totalPrice);
            $attribute = [
                "user_id" => $userId,
                "product_id" => $findProduct->id,
            ];
            $insertCart = [
                "user_id" => $userId,
                "product_id" => $findProduct->id,
                "quantity" => $quantity,
                "total_price" => $totalPrice
            ];
            $addTocart = Cart::firstOrNew($attribute);
            $addTocart->fill($insertCart);
            $addTocart->save();
            if ($addTocart) {
                return GetResponses::postSuccess();
            }
        }
        return GetResponses::inputValidationError();
    }

    /**
     * Remove From Cart
     */

    public function removeCart($id, $userId)
    {
        $findCart = Cart::where('id', $id)->where('user_id', $userId)->first();
        if ($findCart != null) {
            $isDelete = $findCart->delete();
            if ($isDelete) {
                return GetResponses::deleteSuccess();
            }
        }
        return GetResponses::inputValidationError();
    }



    /**
     * Calculate Total Price
     */
    public function totalPrice($price, $quantity)
    {
        $totalPrice = (float)($price * $quantity);
        return $totalPrice;
    }

    /**
     * Checkout
     */

    public function checkOut($userId)
    {
        $findCart = Cart::with('hasProduct')->where('user_id', $userId)->get();
        if ($findCart != null) {
            return GetResponses::returnData($findCart);
        } else {
            return GetResponses::noRecords();
        }
    }

    /**
     * Make Order 
     */

    public function makeOrder($request)
    {
        $cartIds = $request['cartId'];
        foreach ($cartIds as $cart) {
            $trackNumber = rand(10000, 99999);
            // dd($trackNumber);
            $findCart = Cart::find($cart);
            if ($findCart) {
                //Insert To Order Table
                $createOrder = Order::create([
                    'user_id' => $findCart->user_id,
                    'product_id' => $findCart->product_id,
                    'billing_address' => $request->billingAddress,
                    'quantity' => $findCart->quantity,
                    'total_price' => $findCart->total_price,
                    'tracking_number' => '#ABC-' . $trackNumber,
                    //Currently is Paid Coz not implement paymemnt Gateway. 1 means paid, 2 means Due, 3 refund
                    'payment_status' => 1,
                    //1 is pending, 2 is Deliverd 3 is Cancel Order
                    'status' => 1
                ]);
            }
        }
        return GetResponses::postSuccess();
    }
    /**
     * View Order 
     */

    public function viewOrder($id)
    {
        $findOrder = Order::with('hasProduct', 'hasProduct.hasCat', 'hasProduct.hasSubCat')->where('user_id', $id)->get();
        if (count($findOrder) != 0) {
            return GetResponses::returnData($findOrder);
        }else{
            return GetResponses::noRecords();
        }
    }
}
