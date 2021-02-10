<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\SubCategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\UserManagement\UserManageController;
use App\Http\Controllers\User\Product\ProductController as MainProduct;
use App\Http\Controllers\Support\Order\OrderController;
use App\Http\Controllers\Admin\OrderManagement\OrderController as AdminOrder;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
});
Route::group(['middleware' => ['auth:api']], function () use ($router) {
    Route::group(['prefix' => 'admin'], function () use ($router) {
        Route::group(['middleware' => ['can:admin-manage-user']], function () use ($router) {

            /**
             * User Manage
             */
            Route::post('/user/create', [UserManageController::class, 'createUser']);
            Route::post('/user/update/{id}', [UserManageController::class, 'updateUser']);
            Route::get('/user/list', [UserManageController::class, 'userList']);
        });
        Route::group(['middleware' => ['can:admin-manage-product']], function () use ($router) {

            /**
             * Product Category
             */
            Route::post('/category/create', [CategoryController::class, 'createCategory']);
            Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory']);
            Route::get('/category/list', [CategoryController::class, 'categoryList']);
            /**
             * Product Sub Category
             */
            Route::post('/subCategory/create', [SubCategoryController::class, 'createsubCategory']);
            Route::post('/subCategory/update/{id}', [SubCategoryController::class, 'updateSubCategory']);
            Route::get('/subCategory/list', [SubCategoryController::class, 'subCategoryList']);
            /**
             * Product
             */
            Route::post('/product/create', [ProductController::class, 'createProduct']);
            Route::post('/product/update/{id}', [ProductController::class, 'updateProduct']);
            Route::get('/product/list/{pageNo}', [ProductController::class, 'productList']);
        });
        Route::group(['middleware' => ['can:admin-manage-order']], function () use ($router) {

            /**
             * Order
             */
            Route::get('/getuser/order', [AdminOrder::class, 'getOrderByUser']);
            Route::post('/order/update/{id}', [AdminOrder::class, 'updateOrder']);
            Route::delete('/order/{id}', [AdminOrder::class, 'deleteOrder']);
        });
    });
    Route::group(['middleware' => ['can:user-show-product']], function () use ($router) {
        /**
         * For User 
         */

        //Product
        Route::get('/product', [MainProduct::class, 'showProduct']);
        Route::get('/product/details/{id}', [MainProduct::class, 'productDeatils']);
        //Add To cart
        Route::post('/addToCart', [MainProduct::class, 'addTocart']);
        Route::delete('/removeCart/{id}', [MainProduct::class, 'removeCart']);
        //Check Out
        Route::get('/checkout', [MainProduct::class, 'checkOut']);
        //Make Order
        Route::post('/placeorder', [MainProduct::class, 'makeOrder']);
        //Get All Order for User
        Route::get('/myorder', [MainProduct::class, 'myOrder']);
        //Search Product
        Route::post('/product/search', [MainProduct::class, 'searchProduct']);

        /**
         * End User 
         */
    });
    Route::group(['prefix' => 'support'], function () use ($router) {
        Route::group(['middleware' => ['can:support-manage-order']], function () use ($router) {
            /**
             * For Support
             */
            Route::get('/getuser/order', [OrderController::class, 'getUserWithOrder']);
            Route::post('/order/update/{id}', [OrderController::class, 'updateOrder']);
        });
        /**
         * End Support
         */
    });
});


Route::post('/login', [LoginController::class, 'login']);
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/support/login', [LoginController::class, 'supportLogin']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/user/info', [LoginController::class, 'getUsrInfo']);
Route::post('/register', [RegisterController::class, 'register']);
