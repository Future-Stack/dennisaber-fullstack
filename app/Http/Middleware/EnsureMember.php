<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMember
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Bitte melden Sie sich an, um auf diesen Bereich zuzugreifen.');
        }

        $user = Auth::user();

        // Check if account is active
        if (! $user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Ihr Kundenkonto ist deaktiviert oder abgelaufen. Bitte wenden Sie sich an den Support.');
        }

        return $next($request);
    }
}
