<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidateOrangTua
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user->role === 'orang_tua') {
            if (!$user->orangTua || !$user->orangTua->siswa) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Akun orang tua tidak valid.']);
            }
        }

        return $next($request);
    }
}