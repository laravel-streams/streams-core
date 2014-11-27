<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormValidatorInterface;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationPassedEvent;
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

    use DispatchableTrait;

    /**
     * Validate the form request.
     *
     * @param Form $form
     * @return bool|mixed
     */
    public function validate(Form $form)
    {
        $input = $form->getInput();

        $validator = app('validator')->make($input[config('app.locale')], $form->getRules());

        $this->setAttributeNames($validator, $form);

        if ($validator->passes()) {

            $this->dispatch(new ValidationPassedEvent($form));

            return true;
        }

        $form->setErrors($validator->messages());

        $this->dispatch(new ValidationFailedEvent($form));

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

                if ($assignment instanceof AssignmentInterface and $field = $assignment->getField() and $field instanceof FieldInterface) {

                    $attributes[$field->getSlug()] = strtolower(trans($field->getName()));
                }
            }

            $validator->setAttributeNames($attributes);
        }
    }
}
