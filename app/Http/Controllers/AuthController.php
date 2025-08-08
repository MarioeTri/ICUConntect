<?php

namespace App\Http\Controllers;

use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:nurses',
            'password' => 'required|string|min:6|confirmed',
            'face_image' => 'required|string', // Base64 image string
        ]);

        Nurse::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'face_image' => $request->face_image,
        ]);

        Session::flash('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->route('login');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $nurse = Nurse::where('username', $request->username)->first();

        if ($nurse && Hash::check($request->password, $nurse->password)) {
            Session::put('nurse', $nurse->username);
            Session::flash('success', 'Login berhasil!');
            return redirect()->route('nurse_dashboard');
        }

        Session::flash('danger', 'Username atau password salah!');
        return redirect()->route('login');
    }

    public function logout()
    {
        Session::forget('nurse');
        Session::flash('info', 'Anda telah logout.');
        return redirect()->route('landing');
    }
}