<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

class ActionFactory
{
    protected $actions = [
        'save' => [
            'type' => 'success',
            'text' => 'streams::button.save',
        ]
    ];

    public function make(array $parameters)
    {
        if (isset($parameters['action']) && class_exists($parameters['action'])) {
            return app()->make($parameters['action'], $parameters);
        }

        if ($action = array_get($this->actions, array_get($parameters, 'action'))) {
            $parameters = array_replace_recursive($action, array_except($parameters, 'action'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Action\Action', $parameters);
    }
}
