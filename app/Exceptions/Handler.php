<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the throwable types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    
    /**
     * Report or log an throwable.
     * @param Throwable $throwable
     *
     * @return mixed|void
     * @throws Throwable
     */
    public function report(Throwable $throwable)
    {
        parent::report($throwable);
    }

    /**
     * Render an throwable into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $throwable
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $throwable)
    {
        if ( $this->isModelExp( $throwable ) ) {
            return response()->json([
                'error' => 'Invalid Parameter Value in the Request.'
            ], Response::HTTP_NOT_FOUND );
        }
    
        if ( $this->isHttpExp( $throwable ) ) {
            return response()->json([
                'error' => 'Invalid Route or Parameter in the Request.'
            ], Response::HTTP_BAD_REQUEST );
        }
        
        return parent::render($request, $throwable);
    }
    
    /**
     * if its a model not found throwable
     * @param $throwable
     *
     * @return bool
     */
    public function isModelExp( $throwable )
    {
        return $throwable instanceof ModelNotFoundException;
    }
    
    /**
     * if its an http not found throwable
     * @param $throwable
     *
     * @return bool
     */
    public function isHttpExp( $throwable )
    {
        return $throwable instanceof NotFoundHttpException;
    }
}
