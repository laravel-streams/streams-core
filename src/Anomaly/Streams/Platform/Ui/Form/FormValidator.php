<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormValidatorInterface;
use Illuminate\Validation\Validator;

/**
 * Class FormRequest
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormValidator implements FormValidatorInterface
{

    /**
     * Validate the form request.
     *
     * @param array $input
     */
    public function validate(Form $form)
    {
        $data = $form->getData();

        $validator = app('validator')->make($data[config('app.locale')], $form->getRules());

        $this->setAttributeNames($validator, $form);

        if ($validator->passes()) {

            return true;
        }

        $form->setErrors($validator->messages());

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

            foreach ($stream->getAssignments() as $assignment) {

                $attributes[$assignment->field->slug] = strtolower($assignment->getField());
            }

            $validator->setAttributeNames($attributes);
        }
    }
}
