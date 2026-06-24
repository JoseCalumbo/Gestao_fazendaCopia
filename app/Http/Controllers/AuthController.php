<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login.login');
    }

    public function login(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {

            $user = Auth::user();
            $user->update(['ultimo_acesso' => now()]);

            $request->session()->regenerate();

            return response()->json([
                'status' => true,
                'message' => 'Login efetuado com sucesso',
                'redirect' => url('/dashboard'),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Email ou senha inválidos',
        ]);
    }

    public function dashboard()
    {
        return view('dashboard.dashboard');
    }

    /**
     * API - Obtem os dados do utilizador logado 
     */
    public function getAuthUser()
    {
        if (Auth::check()) {
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nivel' => $user->nivel,
                    'estado' => $user->estado,
                    'telefone' => $user->telefone,
                    'foto_url' => $user->foto_url,
                    'iniciais' => $user->iniciais,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sem utilizador autenticado',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
