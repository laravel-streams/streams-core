<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Facades\Event;

/**
 * Trait ProvidesListeners
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesListeners
{

    /**
     * Event listeners.
     *
     * @var array
     */
    public $listeners = [];

    /**
     * Register the event listeners.
     */
    protected function registerListeners()
    {
        foreach ($this->listeners as $event => $classes) {

            foreach ($classes as $key => $listener) {

                $priority = 0;

                /**
                 * If the listener is an integer
                 * then the key is the listener
                 * and listener is priority.
                 */
                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                }

                Event::listen($event, $listener, $priority);
            }
        }
    }
}
