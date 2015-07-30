<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class FormAttributes
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAttributes
{

    /**
     * Make custom validation messages.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function make(FormBuilder $builder)
    {
        $attributes = [];

        /* @var FieldType $field */
        foreach ($builder->getFormFields() as $field) {
            if ($locale = $field->getLocale()) {
                $attributes[$field->getInputName()] = trans($field->getLabel()) . ' (' . $locale . ')';
            } else {
                $attributes[$field->getInputName()] = trans($field->getLabel());
            }
        }

        return $attributes;
    }
}
