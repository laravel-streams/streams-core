<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class UniqueGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class UniqueGuesser
{

    /**
     * Guess the field unique rule.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $mode   = $builder->getFormMode();
        $entry  = $builder->getFormEntry();

        foreach ($fields as &$field) {

            // Guess based on the form mode if applicable.
            if (in_array(($unique = (string)array_get($field, 'unique')), ['create', 'edit'])) {
                $field['unique'] = $unique === $mode;
            }

            if (array_get($field, 'unique')) {

                $unique = 'unique:' . $entry->getTable() . ',' . $field['field'];

                if ($entry && $id = $entry->getId()) {
                    $unique .= ',' . $id;
                }

                $field['rules'][] = $unique . array_get($field, 'unique_extra');
            }
        }

        $builder->setFields($fields);
    }
}
