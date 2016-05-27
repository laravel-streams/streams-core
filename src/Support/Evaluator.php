<?php namespace Anomaly\Streams\Platform\Support;

use ArrayAccess;
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

        /**
         * if the target is a string and is in a traversable
         * format then traverse the target using the arguments.
         */
        if (is_string($target) && !isset($arguments[$target]) && $this->isTraversable($target)) {
            $target = $this->data($arguments, $target, $target);
        }

        return $target;
    }

    /**
     * Check if a string is in a traversable format.
     *
     * @param  $target
     * @return bool
     */
    protected function isTraversable($target)
    {
        return (!preg_match('/[^a-z._]/', $target));
    }

    /**
     * Return the data from the key.
     *
     * @param $arguments
     * @param $target
     * @return mixed
     */
    protected function data($arguments, $target)
    {
        if (is_null($arguments)) {
            return $target;
        }

        $arguments = is_array($arguments) ? $arguments : explode('.', $arguments);

        foreach ($arguments as $segment) {
            if (is_array($target)) {
                if (!array_key_exists($segment, $target)) {
                    return value($target);
                }

                $target = $target[$segment];
            } elseif ($target instanceof ArrayAccess) {
                if (!isset($target[$segment])) {
                    return value($target);
                }

                $target = $target[$segment];
            } elseif (is_object($target)) {

                /**
                 * Check if the method exists first
                 * otherwise we might end up trying to
                 * access relational methods.
                 *
                 * Otherwise this is identical from
                 * data_get helper.
                 */
                if (method_exists($target, $segment) || !isset($target->{$segment})) {
                    return value($target);
                }

                $target = $target->{$segment};
            } else {
                return value($target);
            }
        }

        return $target;
    }
}
