<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldPopulator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldPopulator
{

    /**
     * Populate the fields with entry values.
     *
     * @param FormBuilder $builder
     */
    public function populate(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $entry  = $builder->getFormEntry();

        if (!$entry instanceof EntryInterface) {
            return;
        }

        foreach ($fields as &$field) {

            /**
             * If the field is not already set
             * then get the value off the entry.
             */
            if (!isset($field['value'])) {
                $field['value'] = $entry->getFieldValue($field['field'], array_get($field, 'locale'));
            }
        }

        $builder->setFields($fields);
    }
}
