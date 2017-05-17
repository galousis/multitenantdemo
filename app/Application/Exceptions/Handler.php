<?php

namespace App\Application\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Interfaces\Api\Http\Controllers\ApiController;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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

		if ($exception instanceof NotFoundHttpException) {
			if ($request->segment(1) == 'api') {
				return (new ApiController())->errorNotFound($exception->getMessage());
			}
		}
		if ($exception instanceof AuthorizationException) {
			if ($request->segment(1) == 'api') {
				if($request->user()){
					return (new ApiController())->errorUnauthorized('You need permission to perform this action.');
				}
				return (new ApiController())->errorForbidden('You are not logged in.');
			} else {
				return redirect('login');
			}
		}

		if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
		{
			return response(['Token is invalid'], 401);
		}
		if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
		{
			return response(['Token has expired'], 401);
		}

		if ($this->isHttpException($exception))
		{
			if($exception instanceof NotFoundHttpException)
			{
				return response()->view('exceptions.404', [], 404);
			}
			if($exception instanceof LoginUserServiceException)
			{
				return response()->view('exceptions.404', [], 404);
			}
			return $this->renderHttpException($exception);
		}
		return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
