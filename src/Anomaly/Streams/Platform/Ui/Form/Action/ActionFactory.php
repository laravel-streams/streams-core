<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

class ActionFactory
{

    protected $actions;

    function __construct(ActionRepository $actions)
    {
        $this->actions = $actions;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['action']) and class_exists($parameters['action'])) {

            return app()->make($parameters['action'], $parameters);
        }

        if ($action = array_get($parameters, 'action') and $action = $this->actions->find($action)) {

            $action = array_merge($action, array_except($parameters, 'action'));

            return app()->make($action['action'], $action);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Action\Action', $parameters);
    }
}
 