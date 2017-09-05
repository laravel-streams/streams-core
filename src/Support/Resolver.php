<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Container\Container;

/**
 * Class Resolver
 *
 * This is a handy class for getting input from
 * a callable target.
 *
 * $someArrayConfig = 'MyCallableClass@handle'
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * @param  array $arguments
     * @param  array $options
     * @return mixed
     */
    public function resolve($target, array $arguments = [], array $options = [])
    {
        $method = array_get($options, 'method', 'handle');

        // If it is not string - exit
        if (!is_string($target)) {
            return $target;
        }

        // If is callable like a function
        if (is_callable($target)) {
            return $this->container->call($target, $arguments);
        }
        
        if (count($splitted = explode('@', $target)) === 2
            && class_exists($splitted[0])
            && method_exists($splitted[0], $splitted[1])) {
            $target = $splitted[0];
            $method = $splitted[1];
        }

        // 
        if (class_exists($target) && method_exists($target, $method)) {
            return $this->container->call($target . '@' . $method, $arguments);
        }
    }
}
