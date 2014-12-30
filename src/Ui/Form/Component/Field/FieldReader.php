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
         * If the slug is numeric and the field is
         * a string then treat the string as both the
         * field and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same field which is not likely.
         */
        if (is_numeric($slug) && is_string($field)) {
            $field = [
                'slug'   => $field,
                'button' => $field,
            ];
        }

        /**
         * If the slug is NOT numeric and the field is a
         * string then use the slug as the slug and the
         * field as the field.
         */
        if (!is_numeric($slug) && is_string($field)) {
            $field = [
                'slug'   => $slug,
                'button' => $field,
            ];
        }

        /**
         * If the slug is not numeric and the field is an
         * array without a slug then use the slug for
         * the slug for the field.
         */
        if (is_array($field) && !isset($field['slug']) && !is_numeric($slug)) {
            $field['slug'] = $slug;
        }

        /**
         * Make sure the attributes array is set.
         */
        $field['attributes'] = array_get($field, 'attributes', []);

        /**
         * If the HREF is present outside of the attributes
         * then pull it and put it in the attributes array.
         */
        if (isset($field['href'])) {
            $field['attributes']['href'] = array_pull($field, 'href');
        }

        return $field;
    }
}
