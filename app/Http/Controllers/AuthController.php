<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:4',
            'domisili' => 'required',
            'username' => 'required|min:6',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'nama' => $request->nama,
            'domisili' => $request->domisili,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('lfmAuthApp')->accessToken;
 
        return response()->json(['user' => $user, 'token' => $token], 200);
    }
 
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('lfmAuthApp')->accessToken;
            return response()->json(['status' => true, 'message' => ['token' => $token]], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 200);
        }
    }
}
