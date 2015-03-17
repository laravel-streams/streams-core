<?php namespace Anomaly\Streams\Platform\Image\Command;

use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class AddImageNamespaces
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image\Command
 */
class AddImageNamespaces implements SelfHandling
{

    /**
     * Handle the command.
     */
    public function handle(Image $image, Container $container)
    {
        $image->addPath('asset', $container->make('streams.asset.path'));
        $image->addPath('streams', $container->make('streams.path') . '/resources');
        $image->addPath('bower', $container->make('path.base') . '/bin/bower_components');
    }
}
