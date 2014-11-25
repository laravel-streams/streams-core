<?php namespace Anomaly\Streams\Platform\Ui;

/**
 * Class Utility
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Utility
{

    /**
     * Auto complete a class path based on an object.
     *
     * @param $class
     * @param $object
     * @return string
     */
    public function autoComplete($class, $object)
    {
        if (!starts_with($class, 'Anomaly')) {

            $namespace = $this->getNamespace($object);

            return $namespace . '\\' . $class;
        }

        return $class;
    }

    /**
     * Get the namespace of an object.
     *
     * @param $object
     * @return string
     */
    public function getNamespace($object)
    {
        $namespace = explode('\\', get_class($object));

        array_pop($namespace);

        return implode('\\', $namespace);
    }
}
 