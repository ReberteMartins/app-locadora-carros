<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $credenciais = $request->only(['email', 'password']);

        if (!$token = Auth::guard('api')->attempt($credenciais)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }
        // dd($credenciais);
        return response()->json(['token' => $token], 200);
    }

    public function logout(){
        Auth::guard('api')->logout();
        return response()->json(['msg' => 'Logout foi realizado com sucesso']);
    }

    public function refresh(){
        $token = Auth::guard('api')->refresh();
        return response()->json(['token' => $token]);
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
