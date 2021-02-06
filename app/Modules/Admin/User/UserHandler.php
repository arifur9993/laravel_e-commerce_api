<?php

namespace App\Modules\Admin\User;

use App\Models\Auth\User;
use App\Models\Auth\UserDetail;
use App\Models\Product\ProductCategory;
use Carbon\Carbon;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UserHandler
{

    /**
     * Create User by Admin
     */
    public function createUser($request)
    {
        // dd($request);

        $userInsert = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->roleId,
            'isActive' => '1',
        ];
        //Create User
        $createUser = User::create($userInsert);
        if ($createUser) {
            $detailsInsert = [
                'user_id' => $createUser->id,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email'=>$request->email,
                'address' => isset($request->address) ? $request->address : '',
                'phone_number' => isset($request->phoneNumber) ? $request->phoneNumber : '',
                'image' => $request->profileImage->getClientOriginalName(),
            ];
            $createDetail = UserDetail::create($detailsInsert);
            if ($createDetail) {
                $this->processImage($request->profileImage, $createUser->id);
                return GetResponses::postSuccess();
            }
        }
        return GetResponses::inputValidationError();
    }

    /**
     * Process Image
     */
    public function processImage($file, $id)
    {
        if (!empty($file)) {
            $path = public_path() . '/resources/user/' . $id;
            if (!FacadesFile::isDirectory($path)) {
                Storage::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName = $file->getClientOriginalName();
            $file->move($path, $imageName);
            // dd($imageName);
        }
    }
    /***
     * Update User
     */

    public function updateUser($request, $id)
    {
        //Find Category
        $findUser = User::with('hasDetails')->find($id);

        if ($findUser != null) {
            //Isset Name to update
            if (isset($request->email)) {
                // dd($findUser->name);
                $findUser->email = $request->email;
            }
            //Isset Password to update
            if (isset($request->password)) {
                // dd($findUser->name);
                $findUser->password = Hash::make($request->password);
            }
            //Isset Role to update
            if (isset($request->roleId)) {
                $findUser->role_id = $request->roleId;
            }
            //Isset Active to update
            if (isset($request->isActive)) {
                $findUser->isActive = $request->isActive;
            }
            //Isset Name to update
            if (isset($request->firstName)) {
                // dd($findUser->name);
                $findUser->hasDetails->first_name = $request->firstName;
            }
            if (isset($request->lastName)) {
                // dd($findUser->hasDetails->lastName);
                $findUser->hasDetails->last_name = $request->lastName;
            }
            if (isset($request->address)) {
                // dd($findUser->hasDetails->address);
                $findUser->hasDetails->address = $request->address;
            }
            if (isset($request->phoneNumber)) {
                // dd($findUser->hasDetails->phoneNumber);
                $findUser->hasDetails->phone_number = $request->phoneNumber;
            }
            //Image to update
            if (isset($request->profileImage)) {
                $findUser->image = $request->profileImage->getClientOriginalName();
                $this->processImage($request->profileImage, $findUser->id);

            }
            $findUser->hasDetails->update() && $findUser->update();
            return GetResponses::updateSuccess();
        }
        return GetResponses::inputValidationError();
    }

    /***
     * List User
     */
    public function userList($request)
    {
        $getUser = User::with('hasDetails')->where('role_id','>',1)->orderBy('id', 'desc')->get();
        return GetResponses::returnData($getUser);
    }
}
