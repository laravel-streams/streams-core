<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class PopulateFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PopulateFields
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        if (!$entry = $builder->instance->entry) {
            return;
        }

        $builder->instance->fields->each(function($field) use ($entry) {
            $field->type()->value = $entry->{$field->slug};
        });
    }
}
