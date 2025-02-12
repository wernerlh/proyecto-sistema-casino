<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Si el usuario es "user", solo puede entrar a /usuario
            if ($user->hasRole('user') && !$request->is('usuario')) {
                return redirect('/usuario');
            }

            // Si el usuario intenta entrar a /seguridad pero no es super_admin, redirigir a página de error
            if ($request->is('seguridad') && !$user->hasRole('super_admin')) {
                return redirect('/error');
            }

            return $next($request);
        }

        // Evitar bucles de redirección en la página de login
        if ($request->is('sc/login')) {
            return $next($request);
        }

        return redirect('/sc/login'); // Redirigir al login si no está autenticado
    }
    
}