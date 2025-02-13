<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está autenticado, redirigir al login (excepto para la ruta de login)
        if (auth()->check()) {
            $user = auth()->user();

            // Si el usuario no tiene un cliente_id asociado, redirigir a error
            if (!$user->cliente_id) {
                return response()->view('errors.custom-error', [], 403); // Redirige a la vista personalizada
            }

            // Permitir continuar con la solicitud si todo está bien

            return $next($request);
        }

        // Evitar bucles de redirección en la página de login
        if ($request->is('usuario/login')) {
            return $next($request);
        }

        return redirect('/usuario/login'); // Redirigir al login si no está autenticado
    }
    
}