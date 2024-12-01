<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return back()->with('error', 'Credenciales inválidas');
        }
    } catch (JWTException $e) {
        return back()->with('error', 'Error al generar el token');
    }

    // Almacenar el token en la cookie
    return redirect()->route('dashboard')
        ->with('success', 'Inicio de sesión exitoso')
        ->withCookie(cookie('token', $token, 60)); // Token válido por 60 minutos
}


    // Cerrar sesión
    public function logout()
    {
    try {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return redirect()->route('login.form')->with('success', 'Sesión cerrada con éxito');
    } catch (JWTException $e) {
        return redirect()->route('login.form')->with('error', 'Error al cerrar sesión');
    }
    }

    // Dashboard (usuario autenticado)
    public function dashboard()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return redirect()->route('login.form')->with('error', 'No autorizado');
        }

        return view('welcome', compact('user'));
    }
}
