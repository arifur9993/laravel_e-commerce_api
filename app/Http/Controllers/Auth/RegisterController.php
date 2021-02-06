<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Auth\User;
use App\Models\Auth\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Register For User 
     */
    public function register(Request $request)
    {
        $validatedData = validator($request->only(

            'firstName',
            'lastName',
            'email',
            'address',
            'phoneNumber',
            'designation',
            'password',
            'profileImage'
        ), [
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|max:255',
            'phoneNumber' => 'required|max:20',
            'password' => 'required|min:8|max:20',
            'profileImage' => 'mimes:jpeg,jpg,png,gif|max:2048',

        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        $userInsert = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
            'isActive' => '1',
        ];
        //Create User
        $createUser = User::create($userInsert);
        if ($createUser) {
            $detailsInsert = [
                'user_id' => $createUser->id,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
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
}
