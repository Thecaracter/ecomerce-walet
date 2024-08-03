<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Tangani login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                // Check the user's role and redirect accordingly
                $user = Auth::user();
                if ($user->role === 'admin') {
                    return redirect()->route('dashboard')->with('alert', [
                        'type' => 'success',
                        'message' => 'Login successful. Welcome Admin!',
                    ]);
                } else {
                    return redirect('/')->with('alert', [
                        'type' => 'success',
                        'message' => 'Login successful.',
                    ]);
                }
            }

            return redirect()->route('login')->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput()->with('alert', [
                        'type' => 'error',
                        'message' => 'The provided credentials do not match our records.',
                    ]);
        } catch (Exception $e) {
            return redirect()->route('login')->withInput()->with('alert', [
                'type' => 'error',
                'message' => 'An error occurred. Please try again.',
            ]);
        }
    }



    // Tangani logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'agree' => 'accepted',
        ]);

        try {
            $user = new User();
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->role = 'user'; // Default role

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('foto/profile'), $filename);
                $user->photo = $filename;
            }

            $user->save();

            Auth::login($user);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('alert', [
                    'type' => 'success',
                    'message' => 'Registration successful. Welcome Admin!',
                ]);
            } else {
                return redirect()->route('home')->with('alert', [
                    'type' => 'success',
                    'message' => 'Registration successful. Welcome!',
                ]);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Registration failed. Please try again.',
            ])->withInput();
        }
    }
}
