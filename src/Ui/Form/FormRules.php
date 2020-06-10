<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FormRules
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormRules
{

    /**
     * Compile rules from form fields.
     *
     * @param  FormBuilder $builder
     * @return array
     */
    public function compile(FormBuilder $builder)
    {
        $rules  = $builder->getRules();
        $entry  = $builder->getFormEntry();
        $stream = $builder->getFormStream();

        $locale = config('streams.locales.default');

        /* @var FieldType $field */
        foreach ($builder->getFormFields() as $field) {

            if ($field->disabled) {
                continue;
            }

            if (in_array($field->getField(), $builder->getSkips())) {
                continue;
            }

            $fieldRules = array_filter(Arr::unique($field->rules()));

            // @todo use callback
            //$rules = $field->extendRules($rules);

            if (!$stream instanceof StreamInterface) {

                $rules[$field->getInputName()] = array_merge(
                    Arr::unique($fieldRules),
                    Arr::get($rules, $field->getInputName(), [])
                );

                continue;
            }

            if ($instance = $stream->fields->get($field->getField())) {

                $type = $instance->type();

                if ($type->required) {
                    $fieldRules[] = 'required';
                }

                if (!isset($fieldRules['unique']) && $instance->unique && !$instance->translatable) {

                    $unique = 'unique:' . $stream->model->getTable() . ',' . $field->getUniqueColumnName();

                    if ($entry && $id = $entry->getKey()) {
                        $unique .= ',' . $id;
                    }

                    $fieldRules[] = $unique;
                }

                if ($instance->translatable && $field->getLocale() !== $locale) {
                    $fieldRules = array_diff($fieldRules, ['required']);
                }
            }

            $rules[$field->getInputName()] = array_merge(
                Arr::unique($fieldRules),
                Arr::get($rules, $field->getInputName(), [])
            );
        }

        /**
         * Make sure the rules for each
         * field are in pipe format.
         */
        array_walk(
            $rules,
            function (&$rules) {
                $rules = implode('|', Arr::unique((array) $rules));
            }
        );

        return array_filter($rules);
    }
}
