<?php namespace Streams\Platform\Addon;

class AddonTypeClassResolver
{
    /**
     * Resolve a service provider.
     *
     * @param $type
     * @return string
     */
    public function resolveServiceProvider($type)
    {
        return $this->resolve($type, 'ServiceProvider');
    }

    /**
     * Resolve a repository.
     *
     * @param $type
     * @return string
     */
    public function resolveRepository($type)
    {
        return $this->resolve($type, 'Repository');
    }

    /**
     * Resolve a collection.
     *
     * @param $type
     * @return string
     */
    public function resolveCollection($type)
    {
        return $this->resolve($type, 'Collection');
    }

    /**
     * Resolve a class.
     *
     * @param $type
     * @param $class
     * @return string
     */
    protected function resolve($type, $class)
    {
        $class = $this->getTypeClass($class, $type);

        return class_exists($class) ? $class : null;
    }

    /**
     * Return the type class.
     *
     * @param $class
     * @param $type
     * @return string
     */
    protected function getTypeClass($class, $type)
    {
        return 'Streams\\Platform\\Addon\\' . studly_case($type) . '\\' . studly_case($type) . $class;
    }
}
 