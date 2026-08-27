<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Bitte melden Sie sich als Administrator an.');
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Zugriff verweigert. Nur Administratoren haben hier Zugang.');
        }

        return $next($request);
    }
}
