<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Laravel\Passport\Exceptions\OAuthServerException as LaravelOAuthServerException;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueOAuthServerException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        LeagueOAuthServerException::class,
        LaravelOAuthServerException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  Throwable  $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (method_exists($exception, 'getStatusCode') && blank($exception->getMessage())) {
            if ($exception->getStatusCode() == Response::HTTP_NOT_FOUND) {
                $exception = new NotFoundHttpException('404 Not Found', $exception);
            } else {
                $exception = new HttpException($exception->getStatusCode(), 'Error '.$exception->getStatusCode());
            }
        } elseif ($exception instanceof RoleAlreadyExists) {
            $exception = new HttpException(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $exception->getMessage(),
                $exception
            );
        } elseif ( ! config('app.debug') && $exception instanceof QueryException) {
            $exception = new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Something wrong with your query');
        }

        return parent::render($request, $exception);
    }
}
