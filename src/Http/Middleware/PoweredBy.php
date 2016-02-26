<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;

/**
 * Class PoweredBy
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class PoweredBy
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new PoweredBy instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
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
        /* @var \Illuminate\Http\Response $response */
        $response = $next($request);

        $response->headers->set('X-Powered-By', 'Streams Platform');
        $response->headers->set(
            'X-Streams-Distribution',
            $this->config->get('streams::distribution.name') . '-' . $this->config->get('streams::distribution.version')
        );

        return $response;
    }
}
