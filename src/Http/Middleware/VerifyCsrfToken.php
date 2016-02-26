<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageBag;
use Closure;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Session\TokenMismatchException;

/**
 * Class VerifyCsrfToken
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class VerifyCsrfToken extends \App\Http\Middleware\VerifyCsrfToken
{

    /**
     * The route instance.
     *
     * @var Route
     */
    protected $route;

    /**
     * The message bag.
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
     * Create a new VerifyCsrfToken instance.
     *
     * @param Encrypter  $encrypter
     * @param Redirector $redirector
     * @param MessageBag $messages
     */
    public function __construct(Encrypter $encrypter, Redirector $redirector, MessageBag $messages, Route $route)
    {
        $this->redirector = $redirector;
        $this->messages   = $messages;
        $this->route      = $route;

        parent::__construct($encrypter);
    }

    /**
     * Handle the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param callable                 $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        // If the method is not a post - skip.
        if (!$request->isMethod('post')) {
            return $next($request);
        }

        // Get the route action.
        $action = $this->route->getAction();

        // If the route disabled the CSRF - skip.
        if (array_get($action, 'csrf') === false) {
            return $next($request);
        }

        /**
         * Try validating the CSRF token with the
         * base Laravel Middleware.
         */
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {

            $this->messages->error('streams::message.csrf_token_mismatch');

            return $this->redirector->back();
        }
    }
}
