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

            // If the field depends on other fields, we not add nullable here
            // because validation will not be performed at all on this field
            if (! empty($field['rules'])) {
                if (preg_grep("/required_.*/", $field['rules'])) {
                    continue;
                }
            }

            // If not required then nullable.
            if (isset($field['required']) && $field['required'] == false) {
                $field['rules'][] = 'nullable';
            }

            // If not specified then it's nullable
            if (!isset($field['required'])) {
                $field['rules'][] = 'nullable';
            }
        }

        $builder->setFields($fields);
    }
}
