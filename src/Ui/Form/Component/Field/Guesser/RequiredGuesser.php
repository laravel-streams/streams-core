<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class RequiredGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class RequiredGuesser
{

    /**
     * Guess the field instructions.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $mode   = $builder->getFormMode();
        $entry  = $builder->getFormEntry();

        foreach ($fields as &$field) {

            // Guess based on the assignment if applicable.
            if (
                !isset($field['required'])
                && $entry instanceof EntryInterface
                && $assignment = $entry->getAssignment($field['field'])
            ) {
                $field['required'] = array_get($field, 'required', $assignment->isRequired());
            }

            // Guess based on the form mode if applicable.
            if (in_array(($required = array_get($field, 'required')), ['create', 'edit'])) {
                $field['required'] = $required === $mode;
            }
        }

        $builder->setFields($fields);
    }
}
