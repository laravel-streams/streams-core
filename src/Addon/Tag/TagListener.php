<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Anomaly\Streams\Platform\Addon\Event\RegisteredEvent;

/**
 * Class TagListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag
 */
class TagListener extends AddonListener
{

    /**
     * After the tag is registered to the container
     * register it with our favorite parsing engine.
     *
     * @param RegisteredEvent $event
     */
    public function whenRegistered(RegisteredEvent $event)
    {
        parent::whenRegistered($event);

        $tag = $event->getAddon();

        app('anomaly.lexicon')->registerPlugin($tag->getSlug(), $tag->getAbstract());
    }
}
 