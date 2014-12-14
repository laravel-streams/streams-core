<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonIntegrator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonIntegrator
{
    /**
     * Register the namespaces and integrations for
     * all registered addons of a given type.
     *
     * @param $type
     */
    public function register($type)
    {
        foreach (app('streams.' . str_plural($type)) as $addon) {
            $this->addNamespaces($addon);
        }
    }

    /**
     * Add utility namespaces for an addon.
     *
     * @param Addon $addon
     */
    protected function addNamespaces(Addon $addon)
    {
        $abstract = str_replace('streams.', '', $addon->getAbstract());

        app('view')->addNamespace($abstract, $addon->getPath('resources/views'));
        app('config')->addNamespace($abstract, $addon->getPath('resources/config'));
        app('translator')->addNamespace($abstract, $addon->getPath('resources/lang'));

        app('streams.asset')->addNamespace($abstract, $addon->getPath('resources'));
        app('streams.image')->addNamespace($abstract, $addon->getPath('resources'));
    }
}
