<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Contracts\Container\Container;

/**
 * Class RegisterEvents
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterEvents
{

    /**
     * Handle registering the addon's events.
     *
     * @param AddonServiceProvider $provider
     */
    public function handle(AddonServiceProvider $provider)
    {
        foreach ($provider->listeners as $event => $classes) {
            foreach ($classes as $key => $listener) {

                $priority = 0;

                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                \Event::listen($event, $listener, $priority);
            }
        }
    }
}
