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
        $pendientes = Auth::user()->unreadNotifications;

        // Compartir la variable $pendientes en todas las vistas
        view()->share('pendientes', $pendientes);

        return $next($request);
    }
}
