<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Field\Field;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Workflows\BuildWorkflow;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldFactory;

/**
 * Class FieldTypeBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldBuilder extends Builder
{

    /**
     * The builder attributes.
     *
     * @var array
     */
    protected $attributes = [
        'parent' => null,

        'assets' => [],

        'component' => 'field',

        'field' => Field::class,
        
        'build_workflow' => BuildWorkflow::class,
    ];

    /**
     * Build the fields.
     *
     * @param FormBuilder $builder
     */
    public static function builds(FormBuilder $builder)
    {
        $factory = app(FieldFactory::class);

        FieldInput::read($builder);

        /*
         * Convert each field to a field object
         * and put to the forms field collection.
         */
        foreach ($builder->fields as $field) {

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
            $first->setAttribute('data-keymap', 'f');
        }
    }
}
