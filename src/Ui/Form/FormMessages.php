<?php namespace Anomaly\Streams\Platform\Ui\Form;

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
     * Make custom validation messages.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function make(FormBuilder $builder)
    {
        $messages = [];

        foreach ($builder->getEnabledFormFields() as $field) {

            foreach ($field->getValidators() as $rule => $validator) {

                $message = trans(array_get($validator, 'message'));

                if ($message && str_contains($message, '::')) {
                    $message = trans($message);
                }

                $messages[$rule] = $message;
            }

            foreach ($field->getMessages() as $rule => $message) {

                if ($message && str_contains($message, '::')) {
                    $message = trans($message);
                }

                $messages[$rule] = $message;
            }
        }

        return $messages;
    }
}
