<?php namespace Anomaly\Streams\Platform\Addon\Theme\Command;

class DetectActiveThemeCommandHandler
{
    public function handle()
    {
        if (app('streams.distributions')->active()) {
            if (app('request')->segment(1) == 'admin' || app('request')->segment(1) == 'installer') {
                $theme = config('streams.distribution.admin_theme', 'streams');
            } else {
                $theme = config('streams.distribution.public_theme', 'streams');
            }

            $theme = app('streams.theme.' . $theme);

            if ($theme) {
                $theme->setActive(true);

                // Setup namespace hints for a short namespace.
                app('view')->addNamespace('theme', $theme->getPath('resources/views'));
                app('config')->addNamespace('theme', $theme->getPath('resources/config'));
                app('streams.asset')->addNamespace('theme', $theme->getPath('resources'));
                app('streams.image')->addNamespace('theme', $theme->getPath('resources'));
                app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));
            }
        }
    }
}
