<?php namespace Anomaly\Streams\Platform\Support\Listener;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonsHaveRegistered;
use Anomaly\Streams\Platform\Support\Configurator;

/**
 * Class MergeAddonConfiguration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image\Listener
 */
class MergeAddonConfiguration
{

    /**
     * The configurator utility.
     *
     * @var Configurator
     */
    protected $configurator;

    /**
     * Create a new MergeAddonConfiguration instance.
     *
     * @param Configurator $configurator
     */
    public function __construct(Configurator $configurator)
    {
        $this->configurator = $configurator;
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

            $this->configurator->addNamespace($addon->getNamespace(), $addon->getPath('resources/config'));
            $this->configurator->mergeNamespace(
                $addon->getNamespace(),
                base_path('config/addon/' . $addon->getSlug() . '-' . $addon->getType())
            );
        }
    }
}
