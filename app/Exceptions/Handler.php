<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Verificar si es un error HTTP 500
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            // Mostrar la vista personalizada de error 500
            return response()->view('pages-500', [], 500);
        }

        // Otros errores como 404, 403, etc. pueden ser manejados aquí
        if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
            return response()->view('pages-404', [], 404);
        }

        // Para otros errores, continuar con el comportamiento por defecto
        return parent::render($request, $exception);
    }
}
