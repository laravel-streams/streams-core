<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Support\Resolver;
use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class RedirectProtocol
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class RedirectProtocol
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
     * Create a new RedirectProtocol instance.
     *
     * @param Repository $config
     * @param Resolver   $resolver
     * @param Redirector $redirector
     */
    public function __construct(Repository $config, Resolver $resolver, Redirector $redirector)
    {
        $this->config     = $config;
        $this->resolver   = $resolver;
        $this->redirector = $redirector;
    }

    /**
     * Say it loud.
     *
     * @param  Request  $request
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

        $secure = $request->isSecure();

        $https = $this->resolver->resolve($this->config->get('streams::https.redirect'));

        /**
         * No change.
         */
        if ($https === null) {
            return $next($request);
        }

        /**
         * Force HTTPS
         */
        if ($https === true && !$secure) {
            return $this->redirector->to(str_replace('http://', 'https://', $request->fullUrl()));
        }

        /**
         * Force non-HTTPS
         */
        if ($https === false && $secure) {
            return $this->redirector->to(str_replace('https://', 'http://', $request->fullUrl()));
        }

        return $next($request);
    }
}
