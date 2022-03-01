<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Exception $exception) {
            if($exception instanceof ValidationException){
                return $this->convertValidationExceptionToResponseCustom($exception);
            }
            if($exception instanceof NotFoundHttpException){
                $modelName = $exception->getMessage();
                return $this->errorResponse($modelName !== '' ? $modelName : 'The specified URL cannot be found' , 404);
            }
            if($exception instanceof MethodNotAllowedHttpException){
                return $this->errorResponse('The specified method fo request is invalid!' , 405);
            }
            if($exception instanceof HttpException){
                return $this->errorResponse($exception->getMessage() , $exception->getStatusCode());
            }
            if($exception instanceof QueryException){
                $errorCode = $exception->errorInfo[1];
                if($errorCode == 1451){
                    return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource!' , 409);
                }
            }
            if(!config('app.debug')){
                return $this->errorResponse('Unexpected Exception. Try later!' , 500);
            }

        });
    }

    protected function convertValidationExceptionToResponseCustom(ValidationException $e){
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
