<?php namespace Anomaly\Streams\Platform\Exception;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ExceptionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExceptionHandler extends \Illuminate\Foundation\Exceptions\Handler
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
     * Render an exception into an HTTP response.
     *
     * @param  Request   $request
     * @param  Exception $e
     * @return Response
     */
    public function render($request, Exception $e)
    {
        /**
         * Have to catch this for some reason.
         * Not sure why our handler passes this.
         *
         * @todo: Clean up
         */
        if ($e instanceof AuthenticationException) {
            if ($request->segment(1) === 'admin') {
                return redirect()->guest('admin/login');
            } else {
                return redirect()->guest('login');
            }
        }

        if ($e instanceof HttpException) {
            if (!$e->getStatusCode() == 404) {
                return $this->renderHttpException($e);
            }

            if (($redirect = config('streams::404.redirect')) && $request->path() !== $redirect) {
                return redirect($redirect, 301);
            }

            return $this->renderHttpException($e);
        } elseif (!config('app.debug') && !$e instanceof ValidationException) { // Maybe shouldntRender here?
            return response()->view("streams::errors.500", ['message' => $e->getMessage()], 500);
        } else {
            return parent::render($request, $e);
        }
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        if (!config('app.debug') && view()->exists("streams::errors.{$status}")) {
            return response()->view("streams::errors.{$status}", ['message' => $e->getMessage()], $status);
        } else {
            return (new SymfonyDisplayer(config('app.debug')))->handle($e);
        }
    }

    /**
     * Map exception into an illuminate response.
     *
     * @param  \Symfony\Component\HttpFoundation\Response $response
     * @param  \Exception                                 $e
     * @return \Illuminate\Http\Response
     */
    protected function toIlluminateResponse($response, Exception $e)
    {
        if ($response instanceof SymfonyRedirectResponse) {
            $response = new RedirectResponse(
                $response->getTargetUrl(),
                $response->getStatusCode(),
                $response->headers->all()
            );
        } else {
            $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());
        }

        /**
         * Have to catch this for some reason.
         * Not sure why our handler passes this.
         *
         * @todo: Clean up
         */
        if ($e instanceof AuthenticationException) {

            $path     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $segments = array_filter(explode('/', $path));

            if (array_shift($segments) === 'admin') {
                return redirect()->guest('admin/login');
            } else {
                return redirect()->guest('login');
            }
        }

        return $response->withException($e);
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
