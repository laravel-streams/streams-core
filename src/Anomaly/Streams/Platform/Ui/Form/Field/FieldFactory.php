<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

class FieldFactory
{
    public function make(array $parameters)
    {
        if (isset($parameters['field']) && class_exists($parameters['field'])) {
            return app()->make($parameters['field'], $parameters);
        }

        if (isset($parameters['field'])) {
            return app()->make('Anomaly\Streams\Platform\Ui\Form\Field\Type\StreamsField', $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Field\Field', $parameters);
    }
}
