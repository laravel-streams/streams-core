<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldFiller
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldFiller
{

    /**
     * Fill in fields.
     *
     * @param FormBuilder $builder
     * @return mixed
     */
    public function fill(FormBuilder $builder)
    {
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        /**
         * If no Stream, skip it.
         */
        if (!$stream) {
            return $fields;
        }

        /**
         * Fill with everything by default.
         */
        $fill = $stream->getAssignments()->fieldSlugs();

        /**
         * Loop over field configurations and unset
         * them from the fill fields.
         *
         * If we come across the fill marker then
         * set the position.
         */
        foreach ($fields as $parameters) {

            if (is_string($parameters) && $parameters === '*') {
                continue;
            }

            unset($fill[array_search($parameters['field'], $fill)]);
        }

        /**
         * If we have a fill marker then splice
         * in the remaining fill fields in place
         * of the fill marker.
         */
        if (($position = array_search('*', $fields)) !== false) {

            array_splice($fields, $position, null, $fill);

            unset($fields[array_search('*', $fields)]);
        }

        $builder->setFields($fields);
    }
}
