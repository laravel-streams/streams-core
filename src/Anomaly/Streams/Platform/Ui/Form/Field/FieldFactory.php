<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

class FieldFactory
{

    protected $fields = [];

    public function make(array $parameters)
    {
        if (isset($parameters['field']) and class_exists($parameters['field'])) {

            return app()->make($parameters['field'], $parameters);
        }

        if ($field = array_get($this->fields, array_get($parameters, 'field'))) {

            $parameters = array_replace_recursive($field, array_except($parameters, 'field'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Field\Field', $parameters);
    }
}
 