<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class InstructionsGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser
 */
class InstructionsGuesser
{

    /**
     * Guess the field instructions.
     *
     * @param FormBuilder $builder
     */
    public function guess(FormBuilder $builder)
    {
        $fields = [];

        $stream = $builder->getFormStream();

        foreach ($builder->getFields() as $field) {

            /**
             * If the instructions are already set then use it.
             */
            if (isset($field['instructions'])) {

                $fields[] = $field;

                continue;
            }

            /**
             * If we don't have a field then we
             * can not really guess anything here.
             */
            if (!isset($field['field'])) {

                $fields[] = $field;

                continue;
            }

            /**
             * No stream means we can't
             * really do much here.
             */
            if (!$stream instanceof StreamInterface) {

                $fields[] = $field;

                continue;
            }

            $assignment = $stream->getAssignment($field['field']);

            /**
             * No assignment means we still do
             * not have anything to do here.
             */
            if (!$assignment instanceof AssignmentInterface) {

                $fields[] = $field;

                continue;
            }

            /**
             * Try using the assignment instructions if available.
             */
            if (trans()->has($instructions = $assignment->getInstructions(), array_get($field, 'locale'))) {
                $field['instructions'] = trans($instructions, [], null, array_get($field, 'locale'));
            } elseif ($instructions && !str_is('*.*.*::*', $instructions)) {
                $field['instructions'] = $instructions;
            }

            $fields[] = $field;
        }

        $builder->setFields($fields);
    }
}
