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
         * If the field is a string then use it as
         * the field parameter.
         */
        if (is_string($field)) {
            $field = [
                'field' => $field,
            ];
        }

        /**
         * Move the slug into the field.
         * Not sure if this is actually needed.
         */
        if (is_array($field) && !isset($field['slug'])) {
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
         * If the field parameter is missing then
         * use the slug as the field.
         */
        if (is_array($field) && !isset($field['field'])) {
            $field['field'] = $slug;
        }

        return $field;
    }
}
