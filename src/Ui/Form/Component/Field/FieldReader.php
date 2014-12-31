<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

/**
 * Class FieldReader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldReader
{

    /**
     * Standardize field configuration input.
     *
     * @param $key
     * @param $field
     * @return array
     */
    public function standardize($key, $field)
    {

        /**
         * If the field is a wild card marker
         * then return it as is.
         */
        if ($field == '*') {
            return $field;
        }

        /**
         * If the field is a string then use it as
         * the field parameter.
         */
        if (is_string($field)) {
            $field = [
                'field' => $field,
            ];
        }

        /**
         * If the field parameter is missing then
         * use the key as the field.
         */
        if (is_array($field) && !isset($field['field'])) {
            $field['field'] = $key;
        }

        return $field;
    }
}
