<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
    public function render($request, Throwable $exception){

        // Error en caso de que el usuario introduzca un model que no existe 
        if ($exception instanceof ModelNotFoundException){
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$modelo} con el id especificado", 404);
        }

        // Error en la para la autenticación 
        if ($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }

        // En caso de no contar con los permisos para la URL
        if ($exception instanceof AuthorizationException){
            return $this->errorResponse('No posee permisos para ejectutar esta acción', 403);
        }

        // En caso de haber no haber encontrado la URL solicitada
        if ($exception instanceof NotFoundHttpException){
            return $this->errorResponse('No se encontró la URL especificada', 404);
        }

        // En caso de haber introducido un metodo no valido para la ruta solicitada
        if ($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El método especificado en la petición no es válido', 405);
        }
        
        // En caso de haber exepción en el HTTP
        if ($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        
        // Errores en caso de tener una exepción en la base de datos 
        if ($exception instanceof QueryException){
            $codigo = $exception->errorInfo[1];

            // Error para cuando la base de datos nos salte con un fallo por relación de llaves foraneas 
            if ($codigo == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque está relacionado con algún otro.', 409);    
            }
        }

        // Error generico al estar la aplicación en modo producción ya que los detalles no deben ser mostrados a los usuarios
        if (!config('app.debug')){
            // Error generico pensado en primera instancia en caso de que la API no se pueda conectar con la base de datos
            return $this->errorResponse('Ocurrió un error inesperado. Intente más tarde', 500);
        }

        // Error con detalles para cuando estemos en modo debug
        return parent::render($request, $exception);
    }
}
