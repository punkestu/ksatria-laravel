<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $validation = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        // Check if validation fails
        if ($validation->fails()) {
            $alerts = array_map(function ($message) {
                return [
                    'type' => 'error',
                    'message' => $message,
                ];
            }, $validation->errors()->all());
            return redirect()->back()->with(
                'alerts',
                $alerts
            )->withInput($request->only('email'));
        }

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('alert', [
                'type' => 'success',
                'message' => 'Login berhasil',
            ]);
        }

        // If login fails, redirect back with an error message
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'Login gagal, cek kembali email dan password anda',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('alert', [
            'type' => 'success',
            'message' => 'Logout berhasil',
        ]);
    }
}
