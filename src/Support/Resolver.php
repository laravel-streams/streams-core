<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;

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
     * @var \Illuminate\Contracts\Container\Container
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
     * @param        $target
     * @param array  $arguments
     * @param string $method
     * @return mixed
     */
    public function resolve($target, array $arguments = [], $method = 'handle')
    {
        if (is_string($target) && str_contains($target, '@')) {
            return $this->container->call($target, $arguments);
        } elseif (is_string($target) && class_implements($target, SelfHandling::class)) {
            return $this->container->call($target . '@' . $method, $arguments);
        }

        return $target;
    }
}
