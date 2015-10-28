<?php namespace Anomaly\Streams\Platform\Asset\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Asset\Asset;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;

/**
 * Class AddAssetNamespaces
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Command
 */
class AddAssetNamespaces implements SelfHandling
{

    /**
     * Handle the command.
     */
    public function handle(Asset $asset, Container $container, Application $application)
    {
        $asset->addPath('public', base_path('public'));
        $asset->addPath('asset', $application->getAssetsPath());
        $asset->addPath('storage', $application->getStoragePath());
        $asset->addPath('resources', $application->getResourcesPath());
        $asset->addPath('streams', $container->make('streams.path') . '/resources');
        $asset->addPath('bower', $container->make('path.base') . '/bin/bower_components');
    }
}
