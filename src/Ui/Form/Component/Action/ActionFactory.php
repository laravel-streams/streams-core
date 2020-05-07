<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Action;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class ActionFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionFactory
{

    /**
     * Make an action.
     *
     * @param  array           $parameters
     * @return ActionInterface
     */
    public function make(array $parameters)
    {
        $action = App::make(array_get($parameters, 'action', Action::class), $parameters);

        Hydrator::hydrate($action, $parameters);

        return $action;
    }
}
