<?php namespace Anomaly\Streams\Platform\Asset\Listener;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered;
use Anomaly\Streams\Platform\Asset\AssetPaths;

/**
 * Class AddAddonPaths
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Asset\Listener
 */
class AddAddonPaths
{

    /**
     * The image paths.
     *
     * @var AssetPaths
     */
    protected $paths;

    /**
     * Create a new AddAddonPaths instance.
     *
     * @param AssetPaths $paths
     */
    public function __construct(AssetPaths $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Handle the event.
     *
     * @param AddonsHaveRegistered $event
     */
    public function handle(AddonsHaveRegistered $event)
    {
        $addons = $event->getAddons();

        /* @var Addon $addon */
        foreach ($addons as $addon) {
            $this->paths->addPath($addon->getNamespace(), $addon->getPath('resources'));
        }
    }
}
