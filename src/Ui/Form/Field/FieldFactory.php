<?php namespace Anomaly\Streams\Platform\Ui\Form\Field;

/**
 * Class FieldFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Field
 */
class FieldFactory
{

    /**
     * Make a field.
     *
     * @param array $parameters
     * @return mixed
     */
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
