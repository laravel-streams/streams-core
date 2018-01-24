<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageBag;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VerifyCsrfToken
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class VerifyCsrfToken
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The active route.
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
     * The encrypter implementation.
     *
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    protected $encrypter;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [];

    /**
     * The message bar.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * The redirector utility.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Foundation\Application         $app
     * @param Route                                       $route
     * @param  \Illuminate\Contracts\Encryption\Encrypter $encrypter
     * @param MessageBag                                  $messages
     * @param Redirector                                  $redirector
     */
    public function __construct(
        Application $app,
        Route $route,
        Encrypter $encrypter,
        MessageBag $messages,
        Redirector $redirector
    ) {
        $this->except = config('streams::security.csrf.except', []);

        $this->app        = $app;
        $this->route      = $route;
        $this->encrypter  = $encrypter;
        $this->messages   = $messages;
        $this->redirector = $redirector;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->shouldPassThrough($request) ||
            $this->tokensMatch($request)
        ) {
            return $this->addCookieToResponse($request, $next($request));
        }

        $this->messages->error('streams::message.csrf_token_mismatch');

        return $this->redirector->back(302);
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldPassThrough(Request $request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        /**
         * If the route disabled the
         * CSRF then we can skip it.
         */
        if (array_get($this->route->getAction(), 'csrf') === false) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the application is running unit tests.
     *
     * @return bool
     */
    protected function runningUnitTests()
    {
        return $this->app->runningInConsole() && $this->app->runningUnitTests();
    }

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function tokensMatch(Request $request)
    {
        $sessionToken = $request->session()->token();

        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }

        if (!is_string($sessionToken) || !is_string($token)) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request                   $request
     * @param  \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addCookieToResponse(Request $request, Response $response)
    {
        $config = config('session');

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN', $request->session()->token(), Carbon::now()->getTimestamp() + 60 * $config['lifetime'],
                $config['path'], $config['domain'], $config['secure'], false
            )
        );

        return $response;
    }

    /**
     * Determine if the HTTP request uses a ‘read’ verb.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isReading(Request $request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }
}
