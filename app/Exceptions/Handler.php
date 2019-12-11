<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidatorException) {
            return response()->json([
                'success' => false,
                'error' => [
                    'exception' => $this->getExceptionClass($exception),
                    'message' => $exception->getMessageBag(),
                ],
            ], 400);
        } elseif ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'error' => [
                    'exception' => $this->getExceptionClass($exception),
                    'message' => $exception->errors(),
                ],
            ], 400);
        } elseif ($exception instanceof QueryException) {
            return response()->json([
                'success' => false,
                'error' => [
                    'exception' => $this->getExceptionClass($exception),
                    'message' => $exception->getMessage(),
                ],
            ], 400);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Unauthenticated',
                ],
            ], 401);
        }

        $exception = FlattenException::create($exception);

        if (config('app.debug')) {
            $message = $exception->getMessage();
        } else {
            $message = Response::$statusTexts[$exception->getStatusCode()];
        }

        return response()->json([
            'success' => false,

            'error' => [
                'exception' => $this->getExceptionClass($exception),
                'http_code' => $exception->getStatusCode(),
                'message' => $message,
                'trace' => $this->getTrace($exception),
            ],

        ], $exception->getStatusCode());
    }

    private function getExceptionClass($exception)
    {
        if (config('app.debug')) {
            return get_class($exception);
        }
    }

    private function getTrace($exception)
    {
        if (config('app.debug')) {
            return 'file: '.$exception->getFile().' line: '.$exception->getLine();
        }
    }

}
