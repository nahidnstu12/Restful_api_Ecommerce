<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        // Post -Validation error (422)
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }

        // ModelNotFound Exception (when db go out of bound)(404)
        if($exception instanceof ModelNotFoundException){
            $modelName = \strtolower(\class_basename($exception->getModel()));
            return $this->errorResponse("Does not exists any {$modelName} with the specified identificator",404);
        }

        // AuthorizationException (403)
        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(),403);
        }

        // AuthenticationException (401)
        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }

        // MethodNotAllowedException
        if($exception instanceof MethodNotAllowedException){
            return $this->errorResponse('The specified method for the request is invalid',405);
        }

        // NotFoundHttpException
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('The specified URL cannot be found',404);
        }

        // HttpException
        if($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }

        // QueryException
        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451){
                return $this->errorResponse('Cannot remove this resource permanently.It is releted with any other resources',409);
            }
        }

        //default exception shows when development(debug:true)
        if(config('app.debug')){
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception.Try later',500);        
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        // if ($e->response) {
        //     return $e->response;
        // }

        // return $request->expectsJson() 
        //             ? $this->invalidJson($request, $e)
        //             : $this->invalid($request, $e);

        $err = $e->validator->errors()->getMessages();
        return $this->errorResponse($err,422);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated',401);
    }
}
