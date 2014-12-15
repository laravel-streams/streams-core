<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Event\AddonHasRegistered;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class AddonBinder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonBinder
{

    use EventGenerator;
    use DispatchableTrait;

    /**
     * Register an addon.
     *
     * @param $type
     * @param $slug
     * @param $path
     */
    public function register($type, $slug, $path)
    {
        $addon = 'Anomaly\Streams\Addon\\' . studly_case($type) . '\\' . studly_case(
                $slug
            ) . '\\' . studly_case($slug) . studly_case($type);

        $addon = app($addon)
            ->setPath($path)
            ->setType($type)
            ->setSlug($slug);

        $this->bind($addon);

        $this->raise(new AddonHasRegistered($addon));

        $this->dispatchEventsFor($this);
    }

    /**
     * Bind the addon to the IoC container.
     *
     * @param Addon $addon
     */
    protected function bind(Addon $addon)
    {
        app()->instance($addon->getAbstract(), $addon);
        app()->instance(get_class($addon), $addon);
    }
}
