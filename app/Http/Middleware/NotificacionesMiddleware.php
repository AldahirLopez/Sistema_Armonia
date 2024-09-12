<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ServicioAnexo;
use Illuminate\Support\Facades\Auth;

class NotificacionesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Si el usuario está autenticado, obtener sus notificaciones no leídas
            $pendientes = Auth::user()->unreadNotifications;
            // Compartir las notificaciones en todas las vistas
            view()->share('pendientes', $pendientes);
        } else {
            // Si el usuario no está autenticado, pasar un valor vacío o nulo
            view()->share('pendientes', collect([]));
        }

        return $next($request);
    }
}
