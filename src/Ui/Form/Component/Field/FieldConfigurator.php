<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class FieldConfigurator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldConfigurator
{

    /**
     * Configure the field with the parameters.
     *
     * @param FieldType $field
     * @param           $parameters
     */
    public function configure(FieldType $field, $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($field, $method)) {
                $field->{$method}($value);
            }
        }
    }
}
