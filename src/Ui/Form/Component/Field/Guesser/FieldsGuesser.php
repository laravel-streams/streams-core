<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FieldsGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class FieldsGuesser
{

    /**
     * Guess the fill fields.
     *
     * @param StreamInterface $stream
     * @param array           $fields
     * @return array
     */
    public function guess(StreamInterface $stream, array $fields)
    {
        // Fill with everything by default.
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

        return $fields;
    }
}
