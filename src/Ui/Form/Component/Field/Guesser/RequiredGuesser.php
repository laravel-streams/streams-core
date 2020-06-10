<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class RequiredGuesser
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RequiredGuesser
{

    /**
     * Guess the field required flag.
     *
     * @param FormBuilder $builder
     */
    public static function guess(FormBuilder $builder)
    {
        $rules  = $builder->getRules();
        $fields = $builder->getFields();
        $mode   = $builder->mode;
        $entry  = $builder->getFormEntry();

        foreach ($fields as &$field) {

            /**
             * If the already set, skip.
             */
            if (isset($field['required'])) {
                continue;
            }

            /**
             * If the entry doesn't provide a
             * stream then we can't do much.
             */
            if (!$stream = $entry->stream()) {
                continue;
            }

            // Guess based on the assignment if possible.
            if ($instance = $stream->fields->get($field['field'])) {
                $field['required'] = Arr::get($field, 'required', $instance->required);
            }

            // Guess based on the rules.
            if (in_array('required', Arr::get($field, 'rules', []))) {
                $field['required'] = true;
            }

            // Check builder rules for required flag too.
            if (in_array('required', Arr::get($rules, $field['field'], []))) {
                $field['required'] = true;
            }

            // Guess based on the form mode if applicable.
            if (!is_bool($field['required']) && in_array($field['required'], ['create', 'update'])) {
                $field['required'] = $field['required'] === $mode;
            }
        }

        $builder->setFields($fields);
    }
}
