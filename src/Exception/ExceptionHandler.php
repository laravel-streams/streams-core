<?php namespace Anomaly\Streams\Platform\Exception;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * The exception instance.
     *
     * @var Exception
     */
    protected $exception;

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

        /**
         * Redirect to a custom page if needed
         * in the event that their is one defined.
         */
        if ($e instanceof NotFoundHttpException && $redirect = config('streams::404.redirect')) {
            return redirect($redirect);
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

        $summary = $e->getMessage();
        $headers = $e->getHeaders();
        $code    = $e->getStatusCode();
        $name    = trans("streams::error.{$code}.name");
        $message = trans("streams::error.{$code}.message");
        $id      = $this->container->make(ExceptionIdentifier::class)->identify($this->exception);

        if (view()->exists($view = "streams::errors/{$code}")) {
            return response()->view($view, compact('id', 'code', 'name', 'message', 'summary'), $code, $headers);
        }

        return response()->view(
            'streams::errors/error',
            compact('id', 'code', 'name', 'message', 'summary'),
            $code,
            $headers
        );
    }

    /**
     * Report the error.
     *
     * @param Exception $e
     * @return mixed
     * @throws Exception
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        if (method_exists($e, 'report')) {
            return $e->report();
        }

        /**
         * Stash for later so our
         * identification hashes
         * are the same.
         */
        $this->exception = $e;

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (Exception $ex) {
            throw $e; // throw the original exception
        }

        $id = $this->container->make(ExceptionIdentifier::class)->identify($e);

        $logger->error(
            null,
            [
                'context'        => $this->context(),
                'identification' => ['id' => $id],
                'exception'      => $e,
            ]
        );
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
