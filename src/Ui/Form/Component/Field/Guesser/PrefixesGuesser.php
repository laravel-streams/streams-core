<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class PrefixesGuesser.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class PrefixesGuesser
{
    /**
     * Guess the field placeholders.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $prefix = $builder->getFormOption('prefix');

        foreach ($fields as &$field) {
            array_set($field, 'prefix', array_get($field, 'prefix', $prefix));
        }

        $builder->setFields($fields);
    }
}
