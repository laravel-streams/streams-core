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

            $unique = array_get($field, 'unique');

            /**
             * If unique is true then automate the rule.
             */
            if ($unique && $unique === true) {

                $unique = 'unique:' . $entry->getTable() . ',' . $field['field'];

                if ($entry && $id = $entry->getId()) {
                    $unique .= ',' . $id;
                }

                $field['rules'][] = $unique;
            }

            /**
             * If unique is a string then
             * it's set explicitly.
             */
            if ($unique && is_string($unique)) {
                $field['rules'][] = $unique;
            }
        }

        $builder->setFields($fields);
    }
}
