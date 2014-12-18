<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

/**
 * Class ActionFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionFactory
{

    /**
     * The default action class.
     *
     * @var string
     */
    protected $action = 'Anomaly\Streams\Platform\Ui\Form\Action\Action';

    /**
     * The action repository.
     *
     * @var ActionRepository
     */
    protected $actions;

    /**
     * Create a new ActionFactory instance.
     *
     * @param ActionRepository $actions
     */
    public function __construct(ActionRepository $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Make an action.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if ($action = $this->actions->find(array_get($parameters, 'action'))) {
            $parameters = array_replace_recursive($action, array_except($parameters, 'action'));
        }

        return app()->make(array_get($parameters, 'action', $this->action), $parameters);
    }
}
