<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show forms
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'dob'        => 'nullable|date',
            'gender'     => 'nullable|in:male,female,other',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'dob'        => $validated['dob'] ?? null,
            'gender'     => $validated['gender'] ?? null,
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role_id'    => 2, // default user role
        ]);

        // Auto-login after registration (optional)
        // Auth::login($user);

        // If AJAX request → return JSON
        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'redirect' => route('login'),
                'message'  => 'Registration successful.',
            ]);
        }

        // Normal request → redirect to login
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }


    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // If AJAX request → return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard'),
                    'message' => 'Login successful.',
                ]);
            }

            // Normal request → redirect
            return redirect()->route('dashboard');
        }

        // If AJAX request → return JSON error
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => ['Invalid credentials provided.']
                ]
            ], 422);
        }

        // Normal request → back with errors
        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ]);
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
