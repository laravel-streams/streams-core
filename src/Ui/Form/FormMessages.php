<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class FormMessages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormMessages
{

    /**
     * Extend the validation factory.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function get(FormBuilder $builder)
    {
        $messages = [];

        foreach ($builder->getFormFields() as $field) {
            $this->registerValidationMessages($field, $messages);
        }

        return $messages;
    }

    /**
     * Register field's custom messages.
     *
     * @param FieldType $field
     * @param array     $messages
     */
    protected function registerValidationMessages(FieldType $field, array &$messages)
    {
        foreach ($field->getValidators() as $rule => $validator) {
            $messages[$rule] = array_get($validator, 'message');
        }

        foreach ($field->getMessages() as $rule => $message) {
            $messages[$rule] = $message;
        }
    }
}
