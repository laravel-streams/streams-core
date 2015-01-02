<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Container\Container;

/**
 * Class Resolver
 *
 * This is a handy class for getting input from
 * a callable target.
 *
 * $someArrayConfig = 'MyCallableClass@handle'
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Resolver
{

    /**
     * The IoC container.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Create a new Resolver instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Resolve the target.
     *
     * @param $target
     * @return mixed
     */
    public function resolve($target)
    {
        if (is_string($target) && str_contains($target, '@')) {
            return $this->container->call($target);
        }

        return $target;
    }
}
