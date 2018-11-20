<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class ForceSsl
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ForceSsl
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The redirect utility.
     *
     * @var Redirector
     */
    protected $redirect;

    /**
     * Create a new PoweredBy instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config, Redirector $redirect)
    {
        $this->config   = $config;
        $this->redirect = $redirect;
    }

    /**
     * Force SSL connections.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $force = $this->config->get('streams::system.force_ssl', false);

        if ($force && !$request->isSecure()) {
            return $this->redirect->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
