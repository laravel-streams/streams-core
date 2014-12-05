<?php namespace Anomaly\Streams\Platform\Ui\Form\Layout;

class LayoutFactory
{

    public function make(array $parameters)
    {
        if (isset($parameters['rows'])) {

            return app()->make('Anomaly\Streams\Platform\Ui\Form\Layout\Type\FieldLayout');
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Layout\Layout');
    }
}
 