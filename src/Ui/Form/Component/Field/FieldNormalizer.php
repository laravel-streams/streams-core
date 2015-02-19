<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

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
     * @param FormBuilder $builder
     */
    public function normalize(FormBuilder $builder)
    {
        $fields = $builder->getFields();

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
                    'field' => $field
                ];
            }

            /**
             * If the slug is a string and the field
             * is a string too then use the field as the
             * type and the slug as the field as well.
             */
            if (!is_numeric($slug) && is_string($slug) && is_string($field)) {
                $field = [
                    'slug'  => $slug,
                    'field' => $slug,
                    'type'  => $field
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

        $builder->setFields($fields);
    }
}
