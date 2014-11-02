<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Transformer
 *
 * A utility to return transformed classes
 * or NULL if the class does not exist.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Transformer
{

    /**
     * Transform a class to
     * it's corresponding handler.
     *
     * @param $class
     * @return null|string
     */
    public function to($class, $suffix)
    {
        if (!is_string($class)) {

            $class = get_class($class);
        }

        $class = $class . $suffix;

        if (class_exists($class)) {

            return $class;
        }

        return null;
    }

    /**
     * Handle dynamic calls like toServiceProvider($class)
     *
     * @param       $method
     * @param array $arguments
     * @return null|string
     */
    public function __call($method, array $arguments = [])
    {
        if (starts_with($method, 'to')) {

            return $this->to($arguments[0], substr($method, 2));
        }
    }
}
