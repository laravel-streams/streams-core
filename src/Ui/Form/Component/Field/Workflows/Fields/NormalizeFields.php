<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Workflows\Fields;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class NormalizeFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeFields
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $fields = $builder->fields;

        foreach ($fields as $slug => &$field) {

            /*
             * If the field is a wild card marker
             * then just continue.
             */
            if ($field == '*') {
                continue;
            }

            /*
             * If the slug is numeric and the field
             * is a string then use the field as is.
             */
            if (is_numeric($slug) && is_string($field)) {
                $field = [
                    'field' => $field,
                ];
            }

            /*
             * If the slug is a string and the field
             * is a string too then use the field as the
             * type and the field as well.
             */
            if (!is_numeric($slug) && is_string($slug) && is_string($field)) {
                $field = [
                    'field' => $slug,
                    'type'  => $field,
                ];
            }

            /*
             * If the field is an array and does not
             * have the field parameter set then
             * use the slug.
             */
            if (is_array($field) && !isset($field['field'])) {
                $field['field'] = $slug;
            }

            /*
             * If the field is required then it must have
             * the rule as well.
             */
            if (Arr::get($field, 'required') === true) {
                $field['rules'] = array_unique(array_merge(Arr::get($field, 'rules', []), ['required']));
            }
        }

        $fields = Normalizer::attributes($fields);

        $builder->fields = $fields;
    }
}
