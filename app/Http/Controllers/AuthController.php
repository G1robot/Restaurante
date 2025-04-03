<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioModel;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'contrasena' => 'required'
        ]);

        // Intentamos autenticar como Usuario
        $usuario = UsuarioModel::where('usuario', $request->usuario)
                              ->where('contrasena', $request->contrasena)
                              ->first();

        if ($usuario) {
            Auth::guard('web')->login($usuario);
            return redirect()->route('home')->with('success', 'Bienvenido Usuario');
        } else {
            return back()->withErrors(['error' => 'Credenciales incorrectas']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Sesión cerrada');
    }
}
