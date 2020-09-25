<?php

namespace Anomaly\Streams\Platform\Field;

use Illuminate\Support\Arr;

/**
 * Class FieldInput
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldInput
{

    /**
     * Build the fields.
     *
     * @param array $fields
     * @return array
     */
    public static function read(array $fields)
    {
        foreach ($fields as $handle => &$input) {

            if (is_string($input)) {
                $input = [
                    'type' => $input,
                ];
            }

            if (!isset($input['handle'])) {
                $input['handle'] = $handle;
            }

            // INPUT TEST
            // @todo replace
            if (strpos($input['type'], '|')) {
                list($input['type'], $input['input']) = explode('|', $input['type']);
            }

            $input['rules'] = array_map(function ($rules) {

                if (is_string($rules)) {
                    return explode('|', $rules);
                }
    
                return $rules;
            }, Arr::get($input, 'rules', []));
        }

        return $fields;
    }
}
