<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function user($email) {
        $user = User::where('email', $email)->first();

        return response()->json($user, 200);
    }
}
