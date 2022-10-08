<?php

namespace App\Http\Controllers\API;

use App\Models\Society;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // login
    public function login(Request $request){
        $credential = [
            'id_card_number' => $request->id_card_number,
            'password' => $request->password
        ];

        $user = Society::where($credential)->with('regional')->first();

        $user->makeHidden(['id', 'id_card_number', 'password', 'regional_id']);

        if (!$user) {
            # code...
            return response()->json([
                'message' => 'ID Card Number or Password incorrect'
            ], 401);
        }

        $user->update([
            'login_tokens' => md5($user->id_card_number)
        ]);

        return response()->json($user, 200);

    }


    // logout
    public function logout(Request $request){
        $user = Society::where('login_tokens', $request->token)->first();

        if (!$user) {
            # code...
            return response()->json([
                'message' => 'Invalid token'
            ], 401);
        }

        $user->update([
            'login_tokens' => null
        ]);

        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }
}
