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
        $fields = $builder->getFields();
        $stream = $builder->getFormStream();

        foreach ($fields as &$field) {

            $locale = array_get($field, 'locale');

            /**
             * If the instructions are already set then use it.
             */
            if (isset($field['instructions'])) {

                if (str_is('*::*', $field['instructions'])) {
                    $field['instructions'] = trans($field['instructions'], [], null, $locale);
                }

                continue;
            }

            /**
             * If we don't have a field then we
             * can not really guess anything here.
             */
            if (!isset($field['field'])) {
                continue;
            }

            /**
             * No stream means we can't
             * really do much here.
             */
            if (!$stream instanceof StreamInterface) {
                continue;
            }

            $assignment = $stream->getAssignment($field['field']);

            /**
             * No assignment means we still do
             * not have anything to do here.
             */
            if (!$assignment instanceof AssignmentInterface) {
                continue;
            }

            /**
             * Try using the assignment instructions system.
             * This is generated but check for a field
             * specific variation first.
             */
            $instructions = $assignment->getInstructions() . '.' . $stream->getSlug();

            if (str_is('*::*', $instructions) && trans()->has($instructions, $locale)) {
                $field['instructions'] = trans($instructions, [], null, $locale);
            }

            /**
             * Next try using the fallback assignment
             * instructions system as generated verbatim.
             */
            $instructions = $assignment->getInstructions() . '.default';

            if (!isset($field['instructions']) && str_is('*::*', $instructions) && trans()->has($instructions, $locale)) {
                $field['instructions'] = trans($instructions, [], null, $locale);
            }

            /**
             * Next try using the default assignment
             * instructions system as generated verbatim.
             */
            $instructions = $assignment->getInstructions();

            if (
                !isset($field['instructions'])
                && str_is('*::*', $instructions)
                && trans()->has($instructions, $locale)
                && is_string($translated = trans($instructions, [], null, $locale))
            ) {
                $field['instructions'] = $translated;
            }

            /**
             * Lastly check if it's just a standard string.
             */
            if (!isset($field['instructions']) && $instructions && !str_is('*::*', $instructions)) {
                $field['instructions'] = $instructions;
            }
        }

        $builder->setFields($fields);
    }
}
