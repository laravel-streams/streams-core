<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

class FilterReader
{

    public function convert($key, $value)
    {
        /**
         * If the key is numeric and the value is
         * a string then assume the value is a field
         * type and that the value is the field slug.
         */
        if (is_numeric($key) and is_string($value)) {

            $value = [
                'slug'   => $value,
                'field'  => $value,
                'filter' => 'field',
            ];
        }

        /**
         * If the key is NOT numeric and the value is a
         * string then use the key as the slug and the
         * value as the filter.
         */
        if (!is_numeric($key) and is_string($value)) {

            $value = [
                'slug'   => $key,
                'filter' => $value,
            ];
        }

        /**
         * If the key is not numeric and the value is an
         * array without a slug then use the key for
         * the slug for the filter.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 