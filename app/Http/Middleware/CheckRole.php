<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está autenticado, redirigir al login (excepto para la ruta de login)
        if (!auth()->check()) {
            if ($request->is('sc/login')) {
                return $next($request); // Permitir acceso a la página de login
            }
            return redirect('/sc/login'); // Redirigir al login si no está autenticado
        }

        // Obtener el usuario autenticado
        $user = auth()->user();


        // Si el usuario tiene el rol "panel_user", solo puede acceder a /usuario
        if ($user->hasRole('panel_user') && !$request->is('usuario')) {
            return redirect('/usuario');
        }

        // Si el usuario intenta acceder a /seguridad y no tiene el rol "super_admin", redirigir a error
        if ($request->is('seguridad') && !$user->hasRole('super_admin')) {
            return response()->view('errors.custom-error', [], 403); // Redirige a la vista personalizada
        }

        // Permitir continuar con la solicitud si todo está bien
        return $next($request);
    }
    
}