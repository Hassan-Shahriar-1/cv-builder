<?php

namespace App\Exceptions;

use App\Helpers\ApiResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

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
        });        
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof ModelNotFoundException){
            return ApiResponseHelper::otherResponse(false, 400, trans('messages.404'), [], 400);
        }

        if($e instanceof RouteNotFoundException) {
            return ApiResponseHelper::errorResponse(trans('messages.url_not_found'));
        }

        if($e instanceof AuthenticationException) {
            return ApiResponseHelper::unauthenticateResponse();
        }
    }
}
