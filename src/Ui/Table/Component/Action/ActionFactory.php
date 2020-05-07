<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Illuminate\Support\Facades\Lang;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Action;

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
     * The default action.
     *
     * @var string
     */
    protected $action = Action::class;

    /**
     * Make an action.
     *
     * @param  array           $parameters
     * @return ActionInterface
     */
    public function make(array $parameters)
    {
        $parameters = Lang::translate($parameters);

        Hydrator::hydrate(
            $action = app()->make(array_get($parameters, 'action', $this->action), $parameters),
            $parameters
        );

        return $action;
    }
}
