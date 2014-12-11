<?php namespace Anomaly\Streams\Platform\Addon\Command;

class AddAddonNamespaceHintsCommandHandler
{
    public function handle(AddAddonNamespaceHintsCommand $command)
    {
        foreach (app('streams.addon_types') as $type) {
            $plural = str_plural($type);

            foreach (app("streams.{$plural}")->all() as $addon) {
                $abstract = str_replace('streams.', null, $addon->getAbstract());

                app('view')->addNamespace($abstract, $addon->getPath('resources/views'));
                app('config')->addNamespace($abstract, $addon->getPath('resources/config'));
                app('translator')->addNamespace($abstract, $addon->getPath('resources/lang'));

                app('streams.asset')->addNamespace($abstract, $addon->getPath('resources'));
                app('streams.image')->addNamespace($abstract, $addon->getPath('resources'));
            }
        }
    }
}
