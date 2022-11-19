<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function check(Request $request) {
        return new UserResource(Auth::user());
    }

    public function login(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if(!$validator->passes()){
            return response()->json([
                'errors' => $validator->errors()->toArray(),
            ],422);
        }

        return $this->attemptLogin(
            $request->email,
            $request->password,
            $request->device_name,
        );
    }

    public function register(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed',
            'device_name' => 'required',
        ]);

        if(!$validator->passes()){
            return response()->json([
                'errors' => $validator->errors()->toArray(),
            ],422);
        }
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->attemptLogin(
            $request->email,
            $request->password,
            $request->device_name,
        );
    }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "Logged Out Successfully",
        ],200);
    }

    protected function attemptLogin($email, $password, $device_name){

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)){
            $token = User::where('email', $email)
                ->first()
                ->generateNewToken($device_name);
              
            return response()->json([
                'token' => $token,
                'message' => "Logged in Successfully",
            ],200);

        }else{
            return response()->json([
                'errors' => [
                    'credentials' => ['The provided credentials are incorrect.'],
                ]
            ],422);
        }
    }
}
