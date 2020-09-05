<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->get('email'))->first();

        if (!$user && !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessage([
                'email' => 'Email does not exist or match with our data'
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}
