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
         * If the slug is numeric and the field
         * is a string then use the field as the
         * slug and the field.
         */
        if (is_numeric($slug) && is_string($field)) {
            $field = [
                'slug'  => $field,
                'field' => $field,
            ];
        }

        /**
         * If the field is an array and does not
         * have the field parameter set then
         * use the slug.
         */
        if (is_array($field) && !isset($field['field'])) {
            $field['field'] = $slug;
        }

        return $field;
    }
}
