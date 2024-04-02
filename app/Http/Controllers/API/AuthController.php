<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'required',
            'email'     =>  'required|email',
            'password'  =>  'required',
            'c_password' =>  'required|same:password'
        ]);

        if ($validator->fails()) {
            $response   =   [
                'success'   =>  false,
                'message'   =>  $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password']  =  bcrypt($input['password']);
        $user = User::create($input);

        $success['token']   =   $user->createToken('MyApp')->plainTextToken;
        $success['name']    =   $user->name;
        $response           =   [
            'success'       =>  true,
            'data'          =>  $success,
            'message'       =>  'User register successfully',
            'userid'        =>  $user->id,
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' =>  $request->email, 'password'  =>  $request->password])) {
            $user = Auth::user();

            $success['token']   =   $user->createToken('MyApp')->plainTextToken;
            $success['name']    =   $user->name;
            $response       =   [
                'success'       =>  true,
                'data'          =>  $success,
                'message'       =>  'User register successfully',
                'userid'        =>  $user->id,
            ];
            Session::put('user_id', $user->id);
            Session::put('username', $user->name);

            return response()->json($response, 200);
        } else {
            $response       =   [
                'success'       =>  false,
                'message'       =>  'Unauthorized User'
            ];
            return response()->json($response);
        }
    }

    public function getSessionData()
    {
        $data = [
            'userId' => session('user_id'),
            'username' => session('username'),
            // Add more session data as needed
        ];

        return response()->json($data);
    }
}
