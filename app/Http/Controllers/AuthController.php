<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Dorm Seeker,Dorm Owner,Admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Normalize and map role input to the exact enum values stored in DB
        $validRoles = ['Dorm Seeker', 'Dorm Owner', 'Admin'];
        $inputRole = is_string($request->role) ? trim($request->role) : '';

        // Direct match or case-insensitive match
        $mappedRole = null;
        foreach ($validRoles as $r) {
            if (strcasecmp($r, $inputRole) === 0) {
                $mappedRole = $r;
                break;
            }
        }

        // Try a normalized comparison (remove non-letters) to handle underscores/dashes/spaces
        if (is_null($mappedRole) && $inputRole !== '') {
            $normInput = strtolower(preg_replace('/[^a-z]/', '', $inputRole));
            foreach ($validRoles as $r) {
                $norm = strtolower(preg_replace('/[^a-z]/', '', $r));
                if ($norm === $normInput) {
                    $mappedRole = $r;
                    break;
                }
            }
        }

        if (is_null($mappedRole)) {
            Log::warning('Unrecognized role submitted during registration', ['role' => $request->role]);
            $mappedRole = 'Dorm Seeker';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $mappedRole,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()),
                    'role' => 'Dorm Seeker',
                ]);
                Auth::login($user);
            }

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed!');
        }
    }
}