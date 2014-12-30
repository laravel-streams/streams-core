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
         * If the slug is numeric and the field is a
         * string then use the field the field.
         */
        if (is_numeric($slug) && is_string($field)) {
            $field = [
                'field' => $field,
            ];
        }

        /**
         * If the slug is not numeric and the field is
         * an array without a slug then use the slug.
         */
        if (!is_numeric($slug) && is_array($field) && !isset($field['slug'])) {
            $field['slug'] = $slug;
        }

        /**
         * If the slug is numeric and the field is
         * an array without a slug but has a field
         * then use the field as the slug as well.
         */
        if (is_numeric($slug) && is_array($field) && !isset($field['slug']) && isset($field['field'])) {
            $field['slug'] = $field['field'];
        }

        /**
         * If the slug is not numeric and the field is
         * missing the field then use the slug as the field.
         */
        if (!is_numeric($slug) && is_array($field) && !isset($field['field'])) {
            $field['field'] = $slug;
        }

        return $field;
    }
}
