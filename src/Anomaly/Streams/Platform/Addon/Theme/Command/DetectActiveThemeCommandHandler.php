<?php namespace Anomaly\Streams\Platform\Addon\Theme\Command;

class DetectActiveThemeCommandHandler
{

    public function handle(DetectActiveThemeCommand $command)
    {
        if ($distribution = app('streams.distributions')->active()) {

            if (app('request')->segment(1) == 'admin' or app('request')->segment(1) == 'installer') {

                $theme = $distribution->getDefaultAdminTheme();
            } else {

                $theme = $distribution->getDefaultPublicTheme();
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
 