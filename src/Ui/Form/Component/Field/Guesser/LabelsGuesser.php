<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class LabelsGuesser.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class LabelsGuesser
{
    /**
     * Guess the field labels.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            /*
             * If the label is already set then use it.
             */
            if (isset($field['label'])) {
                continue;
            }

            /*
             * If we don't have a field then we
             * can not really guess anything here.
             */
            if (! isset($field['field'])) {
                continue;
            }

            /*
             * No stream means we can't
             * really do much here.
             */
            if (! $stream) {
                $key = "module::field.{$field['field']}";

                if (trans()->has("{$key}.name")) {
                    $field['label'] = "{$key}.name";
                } else {
                    $field['label'] = "{$key}.label";
                }

                continue;
            }

            $assignment = $stream->getAssignment($field['field']);

            /*
             * No assignment means we still do
             * not have anything to do here.
             */
            if (! $assignment instanceof AssignmentInterface) {
                continue;
            }

            /*
             * Try using the assignment label if available
             * otherwise use the field name as the label.
             */
            if (trans()->has($label = $assignment->getLabel(), array_get($field, 'locale'))) {
                $field['label'] = trans($label, [], null, array_get($field, 'locale'));
            } elseif ($label && ! str_is('*.*.*::*', $label)) {
                $field['label'] = $label;
            } elseif (trans()->has($name = $assignment->getFieldName(), array_get($field, 'locale'))) {
                $field['label'] = trans($name, [], null, array_get($field, 'locale'));
            }
        }

        $builder->setFields($fields);
    }
}
