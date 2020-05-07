<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Str;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class FormAttributes
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormAttributes
{

    /**
     * Make custom validation messages.
     *
     * @param  FormBuilder $builder
     * @return array
     */
    public function make(FormBuilder $builder)
    {
        $attributes = [];

        /* @var FieldType $field */
        foreach ($builder->getFormFields() as $field) {

            $label = $field->label ?: ucfirst(Str::humanize($field->field));

            if (str_contains($label, '::')) {
                $label = trans($label);
            }

            if ($locale = $field->getLocale()) {
                $label .= ' (' . $locale . ')';
            }

            $attributes[$field->getInputName()] = '"' . $label . '"';
        }

        return $attributes;
    }
}
