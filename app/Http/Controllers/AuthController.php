<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();

        $rules = array (
            'nama' => 'required|min:4',
            'domisili' => 'required',
            'username' => 'required|min:6',
            'email' => 'required|email',
            'password' => 'required|min:8',
        );

        $validated = Validator::make($request->all(), $rules);
        $userExist = User::where('username', $request->input('username'))->first();
        $emailExist = User::where('email', $request->input('email'))->first();

        $resArr = [];
        if ($userExist != null) {
            
            $resArr['status'] = false;
            $resArr['message'] = 'Username already exist';

            return response()->json($resArr, 200);
        }

        if ($emailExist != null) {
            $resArr['status'] = false;
            $resArr['message'] = 'Email already exist';

            return response()->json($resArr, 200);
        } 
        
        if ($validated->fails()){
            $error = $validated->messages();
            return response()->json($error, 200);
        }
        else {
            $user->nama = $request->input('nama');
            $user->domisili = $request->input('domisili');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            
            $resArr = [];
            $resArr['token'] = $user->createToken('token')->accessToken;
            $resArr['username'] = $user->username;
            $resArr['status'] = true;

            $user->save();
            return response()->json($resArr, 200);
        }
    }
 
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $user = User::where('email', $data['email'])->first();

            $token = auth()->user()->createToken('lfmAuthApp')->accessToken;
            return response()->json(['status' => true, 'message' => ['email' => $user['email'], 'nama' => $user['nama'], 'token' => $token]], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 200);
        }
    }
}
