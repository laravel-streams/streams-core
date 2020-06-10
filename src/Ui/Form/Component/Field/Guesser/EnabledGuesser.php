<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class EnabledGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EnabledGuesser
{

    /**
     * Guess the field instructions.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $mode   = $builder->mode;

        foreach ($fields as &$field) {

            // Guess based on the form mode if applicable.
            if (in_array((string) $enabled = Arr::get($field, 'enabled', null), ['create', 'update'])) {
                $field['enabled'] = $enabled === $mode;
            }
        }

        $builder->setFields($fields);
    }
}
