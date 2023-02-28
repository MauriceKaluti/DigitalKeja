<?php

namespace App\Exceptions;

use Exception;
use HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Symfony\Component\Debug\Exception\FatalThrowableError;

use Illuminate\Http\RedirectResponse;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;


use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        return parent::render($request, $exception);
    }

    /**
     * Prepare response containing exception render. {{IMPORT FUNCTION FROM LARAVEL 5.5 Master}}
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {

        dd($e);
        $response = $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);

        if ($response->getStatusCode() === 417){

            abort(417);

        }

        if (!$this->isHttpException($e) && config('app.debug')) {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }

        if (!$this->isHttpException($e)) {
            $e = new HttpException( $e->getMessage() , 422);
        }


        return $this->toIlluminateResponse($this->renderHttpException($e), $e);
    }


    protected function toIlluminateResponse($response, Exception $e)
    {


        if ($response instanceof SymfonyRedirectResponse) {
            $response = new RedirectResponse(
                $response->getTargetUrl(), $response->getStatusCode(), $response->headers->all()
            );
        } else {
            $response = new Response(
                $response->getContent(), $response->getStatusCode(), $response->headers->all()
            );
        }

        return $response->withException($e);
    }

    protected function convertExceptionToResponse(Exception $e)
    {
        return SymfonyResponse::create(
            $this->renderExceptionContent($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 417,
            $this->isHttpException($e) ? $e->getHeaders() : []
        );
    }


}
