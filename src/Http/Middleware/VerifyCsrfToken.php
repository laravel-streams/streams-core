<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageBag;
use Closure;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
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
     * The redirector utility.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new VerifyCsrfToken instance.
     *
     * @param Encrypter  $encrypter
     * @param Redirector $redirector
     * @param MessageBag $messages
     */
    public function __construct(Encrypter $encrypter, Redirector $redirector, MessageBag $messages)
    {
        $this->redirector = $redirector;
        $this->messages   = $messages;

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
        /* @var Router $router */
        $router = app('router');

        dd($router->getCurrentRoute());

        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $e) {

            $this->messages->error('streams::message.csrf_token_mismatch');

            return $this->redirector->back();
        }
    }
}
