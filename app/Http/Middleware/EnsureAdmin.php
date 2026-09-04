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

        $user = Auth::user();

        if (! $user->isAdmin() && ! $user->isStaff()) {
            return redirect()->route('login')
                ->with('error', 'Zugriff verweigert. Dieser Bereich ist nur für autorisierte Mitarbeiter und Administratoren zugänglich.');
        }

        if ($user->isStaff()) {
            if ($user->access_from && now()->lt($user->access_from)) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'Ihr Mitarbeiterzugang ist noch nicht aktiv.');
            }
            if ($user->access_until && now()->gt($user->access_until->endOfDay())) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'Ihr Mitarbeiterzugang ist abgelaufen.');
            }
        }

        return $next($request);
    }
}
