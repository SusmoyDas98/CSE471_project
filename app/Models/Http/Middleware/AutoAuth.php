<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AutoAuth
{
    /**
     * Handle an incoming request.
     * Auto-authenticates users for development/testing purposes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not authenticated, auto-login with first user or create one
        if (!auth()->check()) {
            $user = User::first();
            if (!$user) {
                $user = User::create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'seeker',
                ]);
            }
            auth()->login($user);
        }
        
        return $next($request);
    }
}

