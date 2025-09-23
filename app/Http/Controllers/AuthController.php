<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
// app/Http/Controllers/AuthController.php

public function login(Request $request)
{
    // Valida se os campos 'email' e 'password' foram enviados
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // ✅ Correção: Use Auth::user() para pegar o usuário recém-autenticado
        $user = Auth::user();

        // Revoga todos os tokens antigos do usuário para garantir um único login ativo
        $user->tokens()->delete();

        // Cria um novo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Se a autenticação falhar, retorna um erro 401 (Não Autorizado)
    return response()->json(['message' => 'Credenciais inválidas'], 401);
}

    public function logout(Request $request)
    {
        // Revoga apenas o token usado nesta requisição
        $request->user()->currentAccessToken()->delete();

        return response()->json(['msg' => 'Logout realizado com sucesso']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}

