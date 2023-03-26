<?php

declare(strict_types=1);

namespace TestingAspire\Application\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                // You may want to log the error else where
                $response = [
                    'message' => env('APP_DEBUG') ? $e->getMessage() : 'Invalid Request',
                    'code' => $e->getCode(),
                ];
                if (env('APP_DEBUG')) {
                    $response['trace'] = $e->getTrace();
                }
                return response()->json($response, 400);
            }
        });
    }
}
