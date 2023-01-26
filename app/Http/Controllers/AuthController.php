<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Response;
use Auth;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $success = $user->createToken('assignment');

        $response = [
            'success' => true,
            'data' => $success->plainTextToken,
            'message' => 'User Registered Successfully'
        ];

        return response($response, 200);
    }

    public function login(Request $request)
    {
        if ($request->has('email')) {
            $credentials = $request->only('email', 'password');
        } else {
            $error = 'error';
        }
        DB::connection()->enableQueryLog();

dd($credentials, Auth::attempt($credentials),  DB::getQueryLog());

        try {
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = \Auth::user();

        $response = [
            'success' => true,
            'message' => 'Success',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ];

        return response($response, Response::HTTP_OK);
    }
    
    public function userValidate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'sometimes|required',
            'mobile_number' => 'sometimes|required'
        ]);

        $valid = false;
        $msg = '';
        if ($request->has('email')) {
            $valid = User::where('email', $request->email)->exists();
        } elseif ($request->has('mobile_number')) {
            $valid = User::where('mobile_number', $request->mobile_number)->exists();
        }

        if ($valid) {
            $msg = ($request->has('email')) ? 'Email Id' : 'Mobile Number';
            $msg .= ' is already exists.';
        }

        $response = [
            'success' => true,
            'message' => 'Success',
            'data' => [
                'is_valid' => $valid,
                'message' => $msg
            ]
        ];

        return response($response, Response::HTTP_OK);
    }
}
