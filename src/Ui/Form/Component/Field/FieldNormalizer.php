<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

/**
 * Class FieldNormalizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldNormalizer
{

    /**
     * Normalize field input.
     *
     * @param array $fields
     * @return array
     */
    public function normalize(array $fields)
    {
        foreach ($fields as $slug => &$field) {

            /**
             * If the field is a wild card marker
             * then just continue.
             */
            if ($field == '*') {
                continue;
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

            /**
             * If the field is an array and does not
             * have a slug and the slug is valid then
             * move the slug into the field array.
             */
            if (!is_numeric($slug) && !isset($field['slug'])) {
                $field['slug'] = $slug;
            }

            /**
             * Make sure the key is a slug.
             */
            if (is_numeric($slug)) {
                $fields[$field['field']] = $field;

                unset($fields[$slug]);
            }
        }

        return $fields;
    }
}
