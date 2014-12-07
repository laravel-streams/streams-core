<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

class ActionRepository
{

    protected $actions = [
        'save' => [
            'slug'   => 'save',
            'button' => [
                'button' => 'success',
                'text'   => 'button.save',
            ],
        ]
    ];

    public function find($action)
    {
        $action = array_get($this->actions, $action);

        if (is_array($action) and !isset($action['action'])) {

            $action['action'] = 'Anomaly\Streams\Platform\Ui\Form\Action\Action';
        }

        return $action;
    }
}
 