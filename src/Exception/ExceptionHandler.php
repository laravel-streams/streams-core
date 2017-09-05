<?php namespace Anomaly\Streams\Platform\Exception;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExceptionHandler extends Handler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $internalDontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request   $request
     * @param  Exception $e
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        /**
         * Have to catch this for some reason.
         * Not sure why our handler passes this.
         */
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        /**
         * Always show exceptions
         * if not in debug mode.
         */
        if (env('APP_DEBUG') === true) {
            return $this->convertExceptionToResponse($e);
        }

        $status = $e->getStatusCode();

        if (view()->exists($view = "streams::errors/{$status}")) {
            return response()->view($view, ['exception' => $e], $status, $e->getHeaders());
        }

        return $this->convertExceptionToResponse($e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if ($request->segment(1) === 'admin') {
            return redirect()->guest('admin/login');
        } else {
            return redirect()->guest('login');
        }
    }
}
