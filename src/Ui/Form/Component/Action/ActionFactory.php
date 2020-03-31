<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;
use Illuminate\Contracts\Container\Container;

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
     * The service container.
     *
     * @var Container
     */
    private $container;

    /**
     * Create a new ActionFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make an action.
     *
     * @param  array           $parameters
     * @return ActionInterface
     */
    public function make(array $parameters)
    {
        $action = $this->container->make(array_get($parameters, 'action', Action::class), $parameters);

        Hydrator::hydrate($action, $parameters);

        return $action;
    }
}
