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
         * Set the field as the slug. The
         * builder will determine if it is
         * a valid streams field later on.
         */
        $field['field'] = $slug;

        return $field;
    }
}
