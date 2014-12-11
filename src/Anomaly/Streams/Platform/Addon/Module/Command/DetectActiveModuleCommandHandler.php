<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

class DetectActiveModuleCommandHandler
{
    public function handle(DetectActiveModuleCommand $command)
    {
        // Determine the active module.
        if (app('request')->segment(1) == 'admin') {
            $module = app('streams.modules')->findBySlug(app('request')->segment(2));
        } else {
            $module = app('streams.modules')->findBySlug(app('request')->segment(1));
        }

        if ($module) {
            $module->setActive(true);

            // Setup namespace hints for a short namespace.
            app('view')->addNamespace('module', $module->getPath('resources/views'));
            app('streams.asset')->addNamespace('module', $module->getPath('resources'));
            app('streams.image')->addNamespace('module', $module->getPath('resources'));
            app('translator')->addNamespace('module', $module->getPath('resources/lang'));
        }
    }
}
