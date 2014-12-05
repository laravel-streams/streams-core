<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;

class ActionFactory
{

    protected $actions;

    protected $buttonFactory;

    function __construct(ActionRepository $actions, ButtonFactory $buttonFactory)
    {
        $this->actions       = $actions;
        $this->buttonFactory = $buttonFactory;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['action']) and class_exists($parameters['action'])) {

            return $this->makeAction($parameters);
        }

        if ($action = array_get($parameters, 'action') and $action = $this->actions->find($action)) {

            return $this->makeRepositoryAction($action, $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Action\Action', $parameters);
    }

    protected function makeAction(array $parameters)
    {
        $this->makeButton($parameters);

        return app()->make($parameters['action'], $parameters);
    }

    protected function makeRepositoryAction($action, $parameters)
    {
        $action = array_replace_recursive($action, array_except($parameters, 'action'));

        $this->makeButton($action);

        return app()->make($action['action'], $action);
    }

    protected function makeButton(array &$parameters)
    {
        if (isset($parameters['button'])) {

            if (is_string($parameters['button'])) {

                $parameters['button'] = ['button' => $parameters['button']];
            }

            $parameters['button'] = $this->buttonFactory->make($parameters['button']);

            $parameters['button']->setSize('sm');
        }
    }
}
 