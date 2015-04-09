<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Illuminate\Validation\Factory;

/**
 * Class FormExtender
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormExtender
{

    /**
     * Extend the validation factory.
     *
     * @param Factory     $factory
     * @param FormBuilder $builder
     */
    public function extend(Factory $factory, FormBuilder $builder)
    {
        foreach ($builder->getFormFields() as $field) {
            $this->registerValidators($factory, $field);
        }
    }

    /**
     * Register field's custom validators.
     *
     * @param Factory   $factory
     * @param FieldType $field
     */
    protected function registerValidators(Factory $factory, FieldType $field)
    {
        foreach ($field->getValidators() as $rule => $validator) {
            $factory->extend($rule, array_get($validator, 'handler'));
        }
    }
}
