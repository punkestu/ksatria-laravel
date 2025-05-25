<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = Auth::user();
        if (!Auth::check() || !$user->isAdmin()) {
            return redirect('/')->with('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.',
            ]);
        }
        return $next($request);
    }
}
