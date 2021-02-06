<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Admin\User\UserHandler;

class UserManageController extends Controller
{
    /**
     * Create User
     * Via this Api Admin Able to create User/Support/Admin by the role
     */
    public function createUser(Request $request, UserHandler $userHandler)
    {
        $validatedData = validator($request->only(

            'firstName',
            'lastName',
            'email',
            'address',
            'phoneNumber',
            'designation',
            'password',
            'roleId',
            'profileImage'
        ), [
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|max:255',
            'phoneNumber' => 'required|max:20',
            'password' => 'required|min:8|max:20',
            'roleId' => 'required|integer',
            'profileImage' => 'mimes:jpeg,jpg,png,gif|max:2048',

        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $userHandler->createUser($request);
        }else {
            return GetResponses::permissionError();
        } 
    }

    /**
     * Update User 
     * This Api Will update user by admin, can change role_id, password, deactive user etc 
     */
    public function updateUser(Request $request, $id, UserHandler $userHandler)
    {
        $validatedData = validator($request->only(

            'firstName',
            'lastName',
            'email',
            'address',
            'phoneNumber',
            'designation',
            'password',
            'roleId',
            'profileImage'
        ), [
            'firstName' => 'max:50',
            'lastName' => 'max:50',
            'email' => 'email|unique:users,email',
            'address' => 'max:255',
            'phoneNumber' => 'max:20',
            'password' => 'min:8|max:20',
            'roleId' => 'integer',
            'profileImage' => 'mimes:jpeg,jpg,png,gif|max:2048',

        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $userHandler->updateUser($request, $id);
        }else {
            return GetResponses::permissionError();
        } 
    }

    /**
     * List of User
     */
    public function userList(Request $request, UserHandler $userHandler)
    {

        $user = auth('api')->user();

        if (($user->role_id == 1) && $user->isActive == 1) {
            return $userHandler->userList($request);
        }else {
            return GetResponses::permissionError();
        } 
    }
}
