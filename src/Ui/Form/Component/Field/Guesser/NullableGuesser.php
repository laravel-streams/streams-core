<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class NullableGuesser
{

    /**
     * Guess the nullable rule.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();

        foreach ($fields as &$field) {

            // Skip if nullable
            if (isset($field['rules']) && in_array('nullable', $field['rules'])) {
                continue;
            }

            // If not required then nullable.
            if (isset($field['required']) && $field['required'] == false) {
                $field['rules'][] = 'nullable';
            }
        }

        $builder->setFields($fields);
    }
}
