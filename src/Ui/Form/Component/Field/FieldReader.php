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
     * @param $slug
     * @param $field
     * @return array
     */
    public function standardize($slug, $field)
    {

        /**
         * If the field is a wild card marker
         * then return it as is.
         */
        if ($field == '*') {
            return $field;
        }

        /**
         * If the slug is not a valid field and the field
         * is a string the use the field as the field's field.. ^_^
         */
        if (is_numeric($slug) && is_string($field)) {
            $field = [
                'field' => $field,
            ];
        }

        /**
         * If the field parameter is missing then
         * use the key as the field.
         */
        if (is_array($field) && !isset($field['field'])) {
            $field['field'] = $slug;
        }

        return $field;
    }
}
