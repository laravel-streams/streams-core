<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

/**
 * Class FormRequest
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator
{

    /**
     * Validate the form request.
     *
     * @param array $input
     */
    public function validate(Form $form, Factory $factory)
    {
        $data = $form->getData();

        $data = $form->fire('validating', compact('data'));

        $validator = $factory->make($data[config('app.locale')], $form->getRules());

        $this->setAttributeNames($validator, $form);

        if ($validator->passes()) {

            $form->fire('validation_passed');

            return true;
        }

        $form->setErrors($validator->messages());

        $form->fire('validation_failed');

        return false;
    }

    /**
     * Set attribute names from the assignment.
     *
     * @param Validator $validator
     * @param Form      $form
     */
    protected function setAttributeNames(Validator $validator, Form $form)
    {
        if ($stream = $form->getStream()) {

            $attributes = [];

            foreach ($stream->assignments as $assignment) {

                $attributes[$assignment->field->slug] = strtolower($assignment->getFieldName());
            }

            $validator->setAttributeNames($attributes);
        }
    }
}
