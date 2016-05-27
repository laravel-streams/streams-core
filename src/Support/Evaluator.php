<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Container\Container;

/**
 * Class Evaluator
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Support
 */
class Evaluator
{

    /**
     * The IoC container.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new Evaluator instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Evaluate a target entity with arguments.
     *
     * @param        $target
     * @param  array $arguments
     * @return mixed
     */
    public function evaluate($target, array $arguments = [])
    {
        /**
         * If the target is an instance of Closure then
         * call through the IoC it with the arguments.
         */
        if ($target instanceof \Closure) {
            return $this->container->call($target, $arguments);
        }

        /**
         * If the target is an array then evaluate
         * each of it's values.
         */
        if (is_array($target)) {
            foreach ($target as &$value) {
                $value = $this->evaluate($value, $arguments);
            }
        }

        return $target;
    }
}
