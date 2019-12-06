<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldFactory;

/**
 * Class FieldTypeBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldBuilder
{

    /**
     * Build the fields.
     *
     * @param FormBuilder $builder
     */
    public static function build(FormBuilder $builder)
    {
        $skips  = $builder->getSkips();
        $stream = $builder->getFormStream();
        $entry  = $builder->getFormEntry();

        $factory = app(FieldFactory::class);

        FieldInput::read($builder);

        /*
         * Convert each field to a field object
         * and put to the forms field collection.
         */
        foreach ($builder->getFields() as $field) {

            // Continue if skipping.
            if (in_array($field['field'], $skips)) {
                continue;
            }

            // Continue if not enabled.
            if (!array_get($field, 'enabled', true)) {
                continue;
            }

            $builder->addFormField($factory->make($field, $stream, $entry));
        }

        if ($first = $builder->getFormFields()->first()) {
            $first->addAttribute('data-keymap', 'f');
        }
    }
}
