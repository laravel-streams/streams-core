<?php namespace Anomaly\Streams\Platform\Ui\Form\Button;

class ButtonFactory
{

    protected $buttons = [
        'edit' => [
            'text' => 'button.edit',
            'type' => 'warning',
        ],
    ];

    public function make(array $parameters)
    {
        if (isset($parameters['button']) and class_exists($parameters['button'])) {

            return app()->make($parameters['button'], $parameters);
        }

        if ($button = array_get($this->buttons, array_get($parameters, 'button'))) {

            $parameters = array_replace_recursive($button, array_except($parameters, 'button'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\Button\Button', $parameters);
    }
}
 