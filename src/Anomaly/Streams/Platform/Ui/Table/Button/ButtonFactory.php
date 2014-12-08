<?php namespace Anomaly\Streams\Platform\Ui\Table\Button;

class ButtonFactory
{

    public function make(array $parameters)
    {
        if (isset($parameters['button']) and class_exists($parameters['button'])) {

            return app()->make($parameters['button'], $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Table\Button\Button', $parameters);
    }
}
 