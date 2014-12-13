<?php namespace Anomaly\Streams\Platform\Addon;

class AddonIntegrator
{
    public function register($type)
    {
        foreach (app('streams.' . str_plural($type)) as $addon) {
            $this->addNamespaces($addon);
        }
    }

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
