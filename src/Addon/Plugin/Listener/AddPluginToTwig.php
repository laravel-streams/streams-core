<?php

namespace Anomaly\Streams\Platform\Addon\Plugin\Listener;

use Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered;
use TwigBridge\Bridge;

/**
 * Class AddPluginToTwig.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin\Listener
 */
class AddPluginToTwig
{
    /**
     * The Twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * Create a new AddPluginToTwig instance.
     *
     * @param Bridge $twig
     */
    public function __construct(Bridge $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Handle the event.
     *
     * @param PluginWasRegistered $event
     */
    public function handle(PluginWasRegistered $event)
    {
        $this->twig->addExtension($event->getPlugin());
    }
}
