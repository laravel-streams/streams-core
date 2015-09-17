<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class TranslatableGuesser.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class TranslatableGuesser
{
    /**
     * Guess the field instructions.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $entry  = $builder->getFormEntry();

        if (! is_object($entry)) {
            return;
        }

        foreach ($fields as &$field) {
            $field['translatable'] = $entry->isTranslatedAttribute($field['field']);
        }

        $builder->setFields($fields);
    }
}
