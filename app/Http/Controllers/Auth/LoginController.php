<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Auth\User;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GetResponses;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function adminLogin(Request $request)
    {


        // dd(auth('api')->user());
        $validatedData = validator($request->only('email', 'password'), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        // $email = $request->email;
        // // dd( $password);

        $user = User::with('hasRole', 'hasDetails')->where('email', $request->email)->first();
        // dd($user->hasDetails !== null);
        if ($user) {
            if (($user->isActive == 1 && $user->hasDetails !== null) && ($user->role_id == 1)) {

                $userRole = $user->hasRole->name;
                // dd($userRole);

                if (Hash::check($request->password, $user->password)) {
                    // dd($token = $user->createToken('Laravel Password Grant Client')->accessToken);
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = [
                        'status' => 200,
                        'token' => 'Bearer ' . $token,
                        'role_id' => $user->role_id,
                        'role_name' => $userRole
                    ];
                    return response($response);
                } else {
                    $response = 'Password is not matched';
                    return GetResponses::errorMsg($response);
                }
            } else {
                $response =  'User is not valid';
                return GetResponses::errorMsg($response);
            }
        } else {
            $response =  'Invalid credentials';
            return GetResponses::errorMsg($response);
        }
    }
    public function login(Request $request)
    {


        // dd(auth('api')->user());
        $validatedData = validator($request->only('email', 'password'), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        // $email = $request->email;
        // // dd( $password);

        $user = User::with('hasRole', 'hasDetails')->where('email', $request->email)->first();
        // dd($user->hasDetails !== null);
        if ($user) {
            if (($user->isActive == 1 && $user->hasDetails !== null) && ($user->role_id == 2)) {

                $userRole = $user->hasRole->name;
                // dd($userRole);

                if (Hash::check($request->password, $user->password)) {
                    // dd($token = $user->createToken('Laravel Password Grant Client')->accessToken);
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = [
                        'status' => 200,
                        'token' => 'Bearer ' . $token,
                        'role_id' => $user->role_id,
                        'role_name' => $userRole
                    ];
                    return response($response);
                } else {
                    $response = 'Password is not matched';
                    return GetResponses::errorMsg($response);
                }
            } else {
                $response =  'User is not valid';
                return GetResponses::errorMsg($response);
            }
        } else {
            $response =  'Invalid credentials';
            return GetResponses::errorMsg($response);
        }
    }
    public function supportLogin(Request $request)
    {


        // dd(auth('api')->user());
        $validatedData = validator($request->only('email', 'password'), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validatedData->fails()) {
            $jsonError = response()->json($validatedData->errors()->all(), 400);
            return GetResponses::errorMsg($jsonError->original);
        }
        // $email = $request->email;
        // // dd( $password);

        $user = User::with('hasRole', 'hasDetails')->where('email', $request->email)->first();
        // dd($user->hasDetails !== null);
        if ($user) {
            if (($user->isActive == 1 && $user->hasDetails !== null) && ($user->role_id == 3)) {

                $userRole = $user->hasRole->name;
                // dd($userRole);

                if (Hash::check($request->password, $user->password)) {
                    // dd($token = $user->createToken('Laravel Password Grant Client')->accessToken);
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = [
                        'status' => 200,
                        'token' => 'Bearer ' . $token,
                        'role_id' => $user->role_id,
                        'role_name' => $userRole
                    ];
                    return response($response);
                } else {
                    $response = 'Password is not matched';
                    return GetResponses::errorMsg($response);
                }
            } else {
                $response =  'User is not valid';
                return GetResponses::errorMsg($response);
            }
        } else {
            $response =  'Invalid credentials';
            return GetResponses::errorMsg($response);
        }
    }
    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();
        // dd($accessToken);
        $token = $request->user()->tokens->find($accessToken);
        $token->revoke();
        $response = array();
        $response['statuscode'] = 200;
        $response['msg'] = "Successfully logout";
        return response()->json($response)->header('Content-Type', 'application/json');
    }

    public function getUsrInfo(Request $request)
    {
        // dd($request);
        $userId = auth('api')->user()->id;
    
        $findDetails  = User::with('hasDetails', 'hasRole')->where('id', $userId)->first();
        // dd($findDetails['id']);
        // $image = "/resources/users/" . $findDetails['company_id'] . '/' . $findDetails['hasDetails']['image'];
        // if (!file_exists(public_path() . '/resources/users/' . $findDetails['company_id'] . '/' . $findDetails['hasDetails']['image'])) {
        //     $image = "/resources/users/default/user_placeholder.webp";
        // }


        $userItem = [
            'userId' => $findDetails['id'],
            'fullname' => $findDetails['hasDetails']['first_name'] . ' ' . $findDetails['hasDetails']['last_name'],
            'first_name' => $findDetails['hasDetails']['first_name'],
            'last_name' => $findDetails['hasDetails']['last_name'],
            'email' => $findDetails['email'],
            'address' => $findDetails['hasDetails']['address'],
            'phone_number' => $findDetails['hasDetails']['phone_number'],
            'designation' => $findDetails['hasDetails']['designation'],
            'image' => "",
            'roleId' => $findDetails['hasRole']['id'],
            'roleName' => $findDetails['hasRole']['name'],
            'isActive' => $findDetails['isActive'],
        ];
        // $getRoles = Roles::where('id','>', 4)->get()->toArray();
        return GetResponses::returnData($userItem);
    }
    
}
