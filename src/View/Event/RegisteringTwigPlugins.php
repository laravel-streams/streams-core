<?php

namespace Anomaly\Streams\Platform\View\Event;

use TwigBridge\Bridge;

/**
 * Class RegisteringTwigPlugins.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Event
 */
class RegisteringTwigPlugins
{
    /**
     * The Twig instance.
     *
     * @var Bridge
     */
    protected $twig;

    /**
     * Create a new RegisteringTwigPlugins instance.
     *
     * @param Bridge $twig
     */
    public function __construct(Bridge $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Get the Twig instance.
     *
     * @return Bridge
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
