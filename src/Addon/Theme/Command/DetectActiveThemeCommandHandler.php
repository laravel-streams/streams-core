<?php namespace Anomaly\Streams\Platform\Addon\Theme\Command;

use Anomaly\Streams\Platform\Addon\Theme\Theme;

/**
 * Class DetectActiveThemeCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme\Command
 */
class DetectActiveThemeCommandHandler
{

    /**
     * Detect the active theme and set up
     * our environment with it.
     */
    public function handle()
    {
        if (app('streams.distributions')->active()) {

            if (app('request')->segment(1) == 'admin' || app('request')->segment(1) == 'installer') {
                $theme = config('distribution.admin_theme', 'streams');
            } else {
                $theme = config('distribution.public_theme', 'streams');
            }

            $theme = app('streams.theme.' . $theme);

            if ($theme instanceof Theme) {

                $theme->setActive(true);

                app('view')->addNamespace('theme', $theme->getPath('resources/views'));
                app('config')->addNamespace('theme', $theme->getPath('resources/config'));
                app('streams.asset')->addNamespace('theme', $theme->getPath('resources'));
                app('streams.image')->addNamespace('theme', $theme->getPath('resources'));
                app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));
            }
        }
    }
}
