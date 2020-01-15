<?php

namespace Anomaly\Streams\Platform\View\Listener;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\View\Event\ViewComposed;

/**
 * Class DecorateData
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DecorateData
{

    /**
     * Handle the event.
     *
     * @param ViewComposed $event
     */
    public function handle(ViewComposed $event)
    {
        $view = $event->getView();

        if ($data = array_merge($view->getFactory()->getShared(), $view->getData())) {
            foreach ($data as $key => $value) {
                $view[$key] = Decorator::decorate($value);
            }
        }
    }
}
