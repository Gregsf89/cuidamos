<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            $error = [
                'code' => null,
                'message' => null,
                'invalid_inputs' => null
            ];

            $status = 400;
            $error['code'] = !empty($e->getCode()) ? $e->getCode() : 500;
            $status = $error['code'] != 500 ? $status : $error['code'];
            $message = json_decode($e->getMessage(), true);
            if (is_null($message)) {
                $message = $e->getMessage();
            }

            if ($this->isHttpException($e)) {
                $status = $e->getStatusCode();
                $error['code'] = empty($e->getCode()) ? $e->getStatusCode() : $error['code'];
                if ($e->getStatusCode() == '404') {
                    $message = 'route_not_found';
                }
            }

            if (is_array($message)) {
                $invalidInputs = [];
                foreach ($message as $input => $rules) {
                    $invalidInputs[] = [
                        'input' => $input,
                        'rules' => $rules
                    ];
                }
                $error['message'] = 'invalid_inputs';
                $error['invalid_inputs'] = $invalidInputs;
            } else {
                $error['message'] = $message;
            }

            if (config('app.debug', false) === true) {
                $error['trace'] = $e->getTrace();
            }

            if ($this->isHttpException($e)) {
                $error = [
                    'data' => null,
                    'error' => $error
                ];
            }

            return response()->json($error, $status);
        } else {
            return parent::render($request, $e);
        }
    }
}
