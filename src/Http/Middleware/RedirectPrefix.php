<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Support\Resolver;
use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class RedirectPrefix
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class RedirectPrefix
{

    /**
     * An array of URIs to ignore.
     *
     * @var array
     */
    protected $ignored = [
        'admin/*',
        'forms/handle/*'
    ];

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The request redirector.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * Create a new RedirectPrefix instance.
     *
     * @param Repository $config
     * @param Resolver $resolver
     * @param Redirector $redirector
     */
    public function __construct(Repository $config, Resolver $resolver, Redirector $redirector)
    {
        $this->config     = $config;
        $this->resolver   = $resolver;
        $this->redirector = $redirector;
    }

    /**
     * Handle the request.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        /**
         * Check if ignored.
         */
        foreach ($this->ignored as $ignore) {
            if (str_is($ignore, $request->path())) {
                return $next($request);
            }
        }

        $www = starts_with($host = $request->getHost(), 'www.');

        $preferred = $this->resolver->resolve($this->config->get('streams::www.redirect'));

        /**
         * Force WWW
         */
        if ($preferred === 'www' && !$www) {
            return $this->redirector->to(
                str_replace($request->getHost(), 'www.' . $request->getHost(), $request->fullUrl())
            );
        }

        /**
         * Force non-WWW
         */
        if ($preferred === 'non-www' && $www) {
            return $this->redirector->to(preg_replace('/www./', '', $request->fullUrl(), 1));
        }

        return $next($request);
    }
}
